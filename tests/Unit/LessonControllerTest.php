<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonControllerTest extends TestCase
{
    /**
     * Test whether lesson can be loaded
     *
     * @return void
     */
	public function test_lesson_can_be_loaded()
	{
		$course = factory(\App\Course::class, 1)->create();

		$lesson = factory(\App\Lesson::class, 1)->create([
			'course_id' => $course[0]->id,
			]);

		$this->assertEquals($course[0]->id, $lesson[0]->course_id);
	}

    /**
     * Test whether lesson can be saved
     *
     * @return void
     */
	public function test_lesson_can_be_saved()
	{
		$course = factory(\App\Course::class, 1)->create();

		$lesson = factory(\App\Lesson::class, 1)->create([
			'course_id' => $course[0]->id,
			]);

		dd($course[0]->id, $lesson[0]->course_id);

		$this->assertEquals(
			$course[0]->id,
			$lesson[0]->course_id);
	}

    /**
     * Test whether lesson can be updated
     *
     * @return void
     */
	public function test_lesson_can_be_updated()
	{
		$course = factory(\App\Course::class, 1)->create();

		$lesson = factory(\App\Lesson::class, 1)->create([
			'course_id' => $course[0]->id,
			]);

		$this->assertEquals(
			$course[0]->id,
			$lesson[0]->course_id);
	}
}
