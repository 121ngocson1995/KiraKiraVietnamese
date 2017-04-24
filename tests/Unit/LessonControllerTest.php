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
		$lesson = \App\Lesson::create([
			'course_id' => $course[0]->id,
			'lessonNo' => 1,
			'lesson_name' => $str_random(10,true),
			'description' => $faker->sentences(3,true),
			'author' => $faker->name,
			'added_by' => str_random(10,true),
			'last_updated_by' => str_random(10,true),
			]);

		$retrieve_lesson = \App\Lesson::find(1);

		$this->assertEquals($retrieve_lesson->id, $lesson->id);
	}
}
