<?php

namespace Tests\Feature;

use App\Http\Controllers\FeeController;
use App\Models\Fee;
use App\Models\FeeCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FeeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('fee_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('default_amount', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id');
            $table->decimal('total_amount', 10, 2);
            $table->date('due_date');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('fee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id');
            $table->foreignId('enrollment_id');
            $table->foreignId('fee_category_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });

        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id');
            $table->decimal('payment_amount', 10, 2);
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('fee_payments');
        Schema::dropIfExists('fee_details');
        Schema::dropIfExists('fees');
        Schema::dropIfExists('fee_categories');
        Schema::dropIfExists('student_enrollments');

        parent::tearDown();
    }

    public function test_store_saves_amounts_for_selected_categories_only(): void
    {
        $enrollmentId = Schema::getConnection()->table('student_enrollments')->insertGetId([]);
        $tuition = FeeCategory::create(['name' => 'Tuition', 'default_amount' => 100]);
        $books = FeeCategory::create(['name' => 'Books', 'default_amount' => 25.50]);
        $uniform = FeeCategory::create(['name' => 'Uniform', 'default_amount' => 40]);

        $response = app(FeeController::class)->store(Request::create('/fees', 'POST', [
            'enrollment_id' => $enrollmentId,
            'selected_categories' => [$tuition->id, $books->id],
            'amounts' => [
                $tuition->id => '110.00',
                $books->id => '30.00',
                $uniform->id => '999.00',
            ],
            'due_date' => '2026-12-01',
            'status' => 'unpaid',
        ]));

        $fee = Fee::with('details')->firstOrFail();

        $this->assertSame(route('fees.show', $fee), $response->getTargetUrl());
        $this->assertSame(1, Fee::count());
        $this->assertSame('140.00', $fee->total_amount);
        $this->assertCount(2, $fee->details);
        $this->assertEqualsCanonicalizing(
            [$tuition->id, $books->id],
            $fee->details->pluck('fee_category_id')->all()
        );
        $this->assertEqualsCanonicalizing(
            ['110.00', '30.00'],
            $fee->details->pluck('amount')->all()
        );
    }

    public function test_category_amount_endpoint_returns_saved_default_amount(): void
    {
        $category = FeeCategory::create(['name' => 'Tuition', 'default_amount' => 100]);

        $response = app(FeeController::class)->categoryAmount($category);

        $this->assertSame('100.00', $response->getData(true)['amount']);
    }

    public function test_update_replaces_category_details_and_recalculates_total(): void
    {
        $enrollmentId = Schema::getConnection()->table('student_enrollments')->insertGetId([]);
        $tuition = FeeCategory::create(['name' => 'Tuition']);
        $books = FeeCategory::create(['name' => 'Books']);
        $fee = Fee::create([
            'enrollment_id' => $enrollmentId,
            'total_amount' => 125,
            'due_date' => '2026-12-01',
            'status' => 'unpaid',
        ]);
        $fee->details()->createMany([
            ['enrollment_id' => $enrollmentId, 'fee_category_id' => $tuition->id, 'amount' => 100],
            ['enrollment_id' => $enrollmentId, 'fee_category_id' => $books->id, 'amount' => 25],
        ]);

        $response = app(FeeController::class)->update(Request::create('/fees/'.$fee->id, 'PUT', [
            'enrollment_id' => $enrollmentId,
            'amounts' => [
                $tuition->id => '150.00',
                $books->id => '',
            ],
            'due_date' => '2026-12-15',
            'status' => 'unpaid',
        ]), $fee);

        $fee->refresh();
        $fee->load('details');

        $this->assertSame(route('fees.show', $fee), $response->getTargetUrl());
        $this->assertSame('150.00', $fee->total_amount);
        $this->assertCount(1, $fee->details);
        $this->assertSame($tuition->id, $fee->details->first()->fee_category_id);
    }
}
