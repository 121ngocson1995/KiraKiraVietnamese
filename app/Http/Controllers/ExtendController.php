<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LanguageCulture;
use Illuminate\Support\Facades\Input;

class ExtendController extends Controller
{
    /**
     * Create a new controller instance.
     *　新しいコントローラーのインスタンスを作成する。
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth', ['except' => 'load']);
    }

    /**
     * Load data from database.
     * データベースからデータをロードする。
     *
     * @param Request $request
     * @param integer $lessonNo
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function load(Request $request, $lessonNo)
    {
    	
    	$lesson = LessonController::getLesson($lessonNo);
    	$lesson_id = $lesson->id;
    	$elementData = LanguageCulture::where('lesson_id', '=', $lesson_id)->get();
    	$cnt = count($elementData);

    	$slide_imgArr = array();
    	$slide_nameArr = array();

    	if ($cnt != 0)
    	{
    		for ($i=0; $i<$cnt; $i++){
    			$contentArr[$i] = explode( "|", $elementData[$i]->content);
    			$thumbArr[$i] = explode( "|", $elementData[$i]->thumbnail);
    			if ($elementData[$i]->type == 0) {
    				$slide_imgArr[(string)$i] = explode( "|", $elementData[0]->slideshow_images);
    				$slide_nameArr[(string)$i] = explode( "|", $elementData[0]->slideshow_caption);
    			}
    		}
    		foreach ($elementData as $key)
    		{
    			$titleArr[] = $key->title;
    		} 
    		$typeEn = ['Images', 'Song', 'Poem','Idioms','Riddle', 'Play'];
    		$typeVn = ['Hình ảnh đất nước - con người Việt Nam', 'Bài hát dành cho em', 'Em đọc thơ', 'Thành ngữ -Tục ngữ - Ca dao', 'Câu đố', 'Cùng chơi các ban ơi!'];

    		return view("activities.Extendv2", compact(['elementData', 'contentArr','thumbArr', 'slide_imgArr', 'slide_nameArr', 'typeEn', 'typeVn','cnt']));

    	} else {
    		return view("activities.Extendv2", compact(['elementData', 'contentArr','titleArr', 'cnt'])); 
    	}
    }

    public function edit(Request $request)
    {
    	// dd($request->all());
    	if ($request->has('update')) {
    		foreach ($request->update as $id => $value) {
    			$extElement = LanguageCulture::where('id', '=', $id)->first();
    			$extElement->extensionNo = $value['extensionNo'];

    			if ((integer)($value['type']) == 0) {
    				$extElement->title = $value['title'];

    				$caption = '';
    				foreach ($value['caption'] as $captionPart) {
    					if (strcmp($caption, '') != 0) {
    						$caption .= '|';
    					}
    					$caption .= $captionPart;
    				}
    				$extElement->slideshow_caption = $caption;

    				if (array_key_exists('image', $value)) {
    					$dbImages = explode('|', $extElement->slideshow_images);

    					foreach ($value['image'] as $index => $image) {
    						$extension = $image->extension();
    						$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    						$fileName = 'L' . $lessonNo . '_Culture_Slideshow_' . $index . $request->_token . '.' . $extension;

                            $path = 'public/img/Culture/lesson' . $lessonNo;
                            $image->storeAs($path, $fileName);

    						$dbImages[(integer)$index] = $path . '/' . $fileName;
    					}

    					$newImages = '';
    					foreach ($dbImages as $part) {
    						if (strcmp($newImages, '') != 0) {
    							$newImages .= '|';
    						}
    						$newImages .= $part;
    					}
    					$extElement->slideshow_images = $newImages;
    				}

    				$extElement->save();
    			} else if ((integer)($value['type']) == 1) {
    				$extElement->title = $value['title'];
    				$extElement->song_composer = $value['composer'];
    				$extElement->song_performer = $value['performer'];
    				$extElement->content = preg_replace('/\r\n/u', '|', $value['content']);

    				if (array_key_exists('thumbnail', $value)) {
    					$extension = $value['thumbnail']->extension();
    					$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    					$fileName = 'L' . $lessonNo . '_Culture_Song_' .  $id . $request->_token . '.' . $extension;

    					$path = 'img/Culture/lesson' . $lessonNo;
    					Input::file('update.' . $id . '.thumbnail')->move($path, $fileName);

    					$extElement->thumbnail = $path . '/' . $fileName;
    				}

    				if (array_key_exists('song', $value)) {
    					$extension = $value['song']->extension();
    					$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    					$fileName = 'L' . $lessonNo . '_Culture_Song_' .  $id . $request->_token . '.' . $extension;

    					$path = 'audio/Culture/lesson' . $lessonNo;
    					Input::file('update.' . $id . '.song')->move($path, $fileName);

    					$extElement->audio = $path . '/' . $fileName;
    				}

    				$extElement->save();
    			} else if ((integer)($value['type']) == 2) {
    				$extElement->title = $value['title'];
    				$extElement->content = preg_replace('/\r\n/u', '|', $value['content']);
    				$extElement->save();
    			} else if ((integer)($value['type']) == 3) {
    				$extElement->content = preg_replace('/\r\n/u', '|', $value['content']);
    				$extElement->save();
    			} else if ((integer)($value['type']) == 4) {
    				$extElement->title = $value['title'];
    				$extElement->riddle_answer = $value['answer'];
    				$extElement->content = preg_replace('/\r\n/u', '|', $value['content']);

    				if (array_key_exists('thumbnail', $value)) {
    					$extension = $value['thumbnail']->extension();
    					$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    					$fileName = 'L' . $lessonNo . '_Culture_Riddle_Thumbnail_' .  $id . $request->_token . '.' . $extension;

    					$path = 'img/Culture/lesson' . $lessonNo;
    					Input::file('update.' . $id . '.thumbnail')->move($path, $fileName);

    					$extElement->thumbnail = $path . '/' . $fileName;
    				}

    				$extElement->save();
    			} else if ((integer)($value['type']) == 5) {
    				$extElement->title = $value['title'];
    				$extElement->content = preg_replace('/\r\n/u', '|', $value['content']);

    				if (array_key_exists('thumbnail', $value)) {
    					$extension = $value['thumbnail']->extension();
    					$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    					$fileName = 'L' . $lessonNo . '_Culture_Game_Thumbnail_' .  $id . $request->_token . '.' . $extension;

    					$path = 'img/Culture/lesson' . $lessonNo;
    					Input::file('update.' . $id . '.thumbnail')->move($path, $fileName);

    					$extElement->thumbnail = $path . '/' . $fileName;
    				}

    				$extElement->save();
    			}
    		}
    	}

    	if ($request->has('insert')) {
    		foreach ($request->insert as $id => $value) {

    			if ((integer)($value['type']) == 0) {

    				$caption = '';
    				if (strcmp($caption, '') != 0) {
    					$caption .= '|';
    				}
    				$caption .= $captionPart;

    				$dbImages = explode('|', $extElement->slideshow_images);

    				foreach ($value['image'] as $index => $image) {
    					$extension = $image->extension();
    					$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    					$fileName = 'L' . $lessonNo . '_Culture_Slideshow_' . $index . $request->_token . '.' . $extension;

    					$path = 'img/Culture/lesson' . $lessonNo;
    					Input::file('insert.' . $id . '.image.' . $index)->move($path, $fileName);

    					$dbImages[(integer)$index] = $path . '/' . $fileName;
    				}

    				$newImages = '';
    				foreach ($dbImages as $part) {
    					if (strcmp($newImages, '') != 0) {
    						$newImages .= '|';
    					}
    					$newImages .= $part;
    				}

    				LanguageCulture::create([
    					'lesson_id' => $request->lessonId,
    					'extensionNo' => (integer)($value['extensionNo']),
    					'type' => 0,
    					'title' => $value['title'],
    					'slideshow_caption' => $caption,
    					'slideshow_images' => $newImages,
    					]);
    			} else if ((integer)($value['type']) == 1) {
    				$extension_img = $value['thumbnail']->extension();
    				$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    				$fileName_img = 'L' . $lessonNo . '_Culture_Song_' .  $id . $request->_token . '.' . $extension_img;

    				$path_img = 'img/Culture/lesson' . $lessonNo;
    				Input::file('insert.' . $id . '.thumbnail')->move($path_img, $fileName_img);

    				$extension_au = $value['song']->extension();
    				$fileName_au = 'L' . $lessonNo . '_Culture_Song_' .  $id . $request->_token . '.' . $extension_au;

    				$path_au = 'audio/Culture/lesson' . $lessonNo;
    				Input::file('insert.' . $id . '.song')->move($path_au, $fileName_au);

    				LanguageCulture::create([
    					'lesson_id' => $request->lessonId,
    					'extensionNo' => (integer)($value['extensionNo']),
    					'type' => 1,
    					'title' => $value['title'],
    					'content' => preg_replace('/\r\n/u', '|', $value['content']),
    					'thumbnail' => $path_img . '/' . $fileName_img,
    					'audio' => $path_au . '/' . $fileName_au,
    					'song_composer' => $path_au . '/' . $fileName_au,
    					'song_performer' => $value['performer'],
    					]);
    			} else if ((integer)($value['type']) == 2) {
    				LanguageCulture::create([
    					'lesson_id' => $request->lessonId,
    					'extensionNo' => (integer)($value['extensionNo']),
    					'type' => 2,
    					'title' => $value['title'],
    					'content' => preg_replace('/\r\n/u', '|', $value['content']),
    					]);
    			} else if ((integer)($value['type']) == 3) {
    				LanguageCulture::create([
    					'lesson_id' => $request->lessonId,
    					'extensionNo' => (integer)($value['extensionNo']),
    					'type' => 3,
    					'content' => preg_replace('/\r\n/u', '|', $value['content']),
    					]);
    			} else if ((integer)($value['type']) == 4) {
    				$extension = $value['thumbnail']->extension();
    				$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    				$fileName = 'L' . $lessonNo . '_Culture_Riddle_Thumbnail_' .  $id . $request->_token . '.' . $extension;

    				$path = 'img/Culture/lesson' . $lessonNo;
    				Input::file('insert.' . $id . '.thumbnail')->move($path, $fileName);

    				LanguageCulture::create([
    					'lesson_id' => $request->lessonId,
    					'extensionNo' => (integer)($value['extensionNo']),
    					'type' => 4,
    					'title' => $value['title'],
    					'content' => preg_replace('/\r\n/u', '|', $value['content']),
    					'thumbnail' => $path . '/' . $fileName,
    					'riddle_answer' => $value['answer'],
    					]);
    			} else if ((integer)($value['type']) == 5) {
    				$extension = $value['thumbnail']->extension();
    				$lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    				$fileName = 'L' . $lessonNo . '_Culture_Game_Thumbnail_' .  $id . $request->_token . '.' . $extension;

    				$path = 'img/Culture/lesson' . $lessonNo;
    				Input::file('update.' . $id . '.thumbnail')->move($path, $fileName);

    				LanguageCulture::create([
    					'lesson_id' => $request->lessonId,
    					'extensionNo' => (integer)($value['extensionNo']),
    					'type' => 5,
    					'title' => $value['title'],
    					'content' => preg_replace('/\r\n/u', '|', $value['content']),
    					'thumbnail' => $path . '/' . $fileName,
    					]);
    			}
    		}
    	}

        if ($request->has('delete')) {
            foreach (explode(',', $request->delete) as $id) {
                LanguageCulture::where('id', '=', $id)->delete();
            }
        }

    	return Redirect("/listAct".$request->all()['lessonId']);
    }
}



