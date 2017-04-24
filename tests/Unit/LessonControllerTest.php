<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonControllerTest extends TestCase
{
	/** @test */
	public function test_lesson_can_be_loaded()
	{
		$course = factory(\App\Course::class, 1)->create();

		// dd($course[0]->id);

		// parent::setUp();
		$lesson = factory(\App\Lesson::class, 1)->create([
			'course_id' => $course[0]->id,
			]);

		$retrieve_lesson = \App\Lesson::find(1);

		$this->assertEquals($retrieve_lesson->id, $lesson->id);
	}
}
