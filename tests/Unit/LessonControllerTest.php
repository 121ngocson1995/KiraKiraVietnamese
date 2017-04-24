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

		dd($course->id);

		parent::setUp();
		$lesson = \App\Lesson::create([
			'course_id' => $course->id,
			'lessonNo' => 1,
			'lesson_name' => $faker->sentence,
			'description' => $faker->sentences,
			'author' => $faker->name,
			'added_by' => str_random(10),
			'last_updated_by' => str_random(10),
			]);

		$retrieve_lesson = \App\Lesson::find(1);

		$this->assertEquals($retrieve_lesson->id, $lesson->id);
		$this->assertEquals($retrieve_lesson->id, $lesson->id);
		$this->assertEquals($retrieve_lesson->id, $lesson->id);
	}
}
