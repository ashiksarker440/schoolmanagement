<?php

namespace Tests\Feature;

use App\Models\ClassRoom;
use App\Models\Group;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\StudentSession;
use App\Models\Shift;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentEnrollmentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('gender')->nullable();
            $table->integer('religion')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('photo')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_profession')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_profession')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        foreach (['student_sessions', 'groups', 'shifts'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('class_id');
            $table->foreignId('section_id');
            $table->foreignId('student_session_id')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->foreignId('shift_id')->nullable();
            $table->string('roll_no')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('student_enrollments');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('student_sessions');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('students');

        parent::tearDown();
    }

    public function test_student_enrollment_returns_the_latest_academic_details(): void
    {
        $student = Student::create(['name' => 'Taylor Student']);
        $oldClass = ClassRoom::create(['name' => 'Class 1']);
        $newClass = ClassRoom::create(['name' => 'Class 2']);
        $oldSection = Section::create(['name' => 'A']);
        $newSection = Section::create(['name' => 'B']);

        StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $oldClass->id,
            'section_id' => $oldSection->id,
        ]);
        StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $newClass->id,
            'section_id' => $newSection->id,
        ]);

        $student->load('enrollment.classRoom', 'enrollment.section');

        $this->assertSame(2, $student->enrollments()->count());
        $this->assertSame('Class 2', $student->enrollment->classRoom->name);
        $this->assertSame('B', $student->enrollment->section->name);
    }

    public function test_update_edits_student_details_and_latest_enrollment(): void
    {
        $student = Student::create(['name' => 'Taylor Student']);
        $oldClass = ClassRoom::create(['name' => 'Class 1']);
        $newClass = ClassRoom::create(['name' => 'Class 2']);
        $oldSection = Section::create(['name' => 'A']);
        $newSection = Section::create(['name' => 'B']);
        $studentSession = StudentSession::create(['name' => '2025-2026']);
        $group = Group::create(['name' => 'Science']);
        $shift = Shift::create(['name' => 'Morning']);

        $previousEnrollment = StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $oldClass->id,
            'section_id' => $oldSection->id,
        ]);
        $latestEnrollment = StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $newClass->id,
            'section_id' => $newSection->id,
        ]);

        app(StudentController::class)->update(Request::create('/students/1', 'PUT', [
            'name' => 'Updated Student',
            'date_of_birth' => '2012-05-04',
            'gender' => '1',
            'religion' => '1',
            'blood_group' => 'O+',
            'birth_certificate' => 'BC-123',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'father_phone' => '0123456789',
            'mother_phone' => '0198765432',
            'father_profession' => 'Teacher',
            'mother_profession' => 'Doctor',
            'class_id' => $oldClass->id,
            'section_id' => $oldSection->id,
            'student_session_id' => $studentSession->id,
            'group_id' => $group->id,
            'shift_id' => $shift->id,
            'roll_no' => '7',
            'guardian_name' => 'Guardian Name',
            'guardian_phone' => '0111222333',
            'address' => 'Updated address',
        ]), $student);

        $student->refresh();
        $latestEnrollment->refresh();
        $previousEnrollment->refresh();

        $this->assertSame('Updated Student', $student->name);
        $this->assertSame('Father Name', $student->father_name);
        $this->assertSame('Class 1', $latestEnrollment->classRoom->name);
        $this->assertSame('7', $latestEnrollment->roll_no);
        $this->assertSame($oldClass->id, $previousEnrollment->class_id);
        $this->assertSame(2, $student->enrollments()->count());
    }

    public function test_student_details_load_latest_enrollment_and_related_names(): void
    {
        $student = Student::create([
            'name' => 'Taylor Student',
            'father_name' => 'Taylor Father',
        ]);
        $oldClass = ClassRoom::create(['name' => 'Class 1']);
        $latestClass = ClassRoom::create(['name' => 'Class 2']);
        $oldSection = Section::create(['name' => 'A']);
        $latestSection = Section::create(['name' => 'B']);

        StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $oldClass->id,
            'section_id' => $oldSection->id,
        ]);
        StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $latestClass->id,
            'section_id' => $latestSection->id,
        ]);

        $response = app(StudentController::class)->show($student);
        $shownStudent = $response->getData()['student'];

        $this->assertSame('students.show', $response->name());
        $this->assertSame('Taylor Father', $shownStudent->father_name);
        $this->assertSame('Class 2', $shownStudent->enrollment->classRoom->name);
        $this->assertSame('B', $shownStudent->enrollment->section->name);
        $this->assertTrue($shownStudent->enrollment->relationLoaded('classRoom'));
    }
}
