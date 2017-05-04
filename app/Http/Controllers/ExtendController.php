<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\LanguageCulture;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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
        if (count($lesson) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The lesson you\'ve chosen has yet been created.');
            return back();
        }
        $lesson_id = $lesson->id;

        $elementData = LanguageCulture::where('lesson_id', '=', $lesson_id)->get();
        if (count($elementData) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }
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
   $typeVn = ['Hình ảnh đất nước - con người Việt Nam', 'Bài hát dành cho em', 'Em đọc thơ', 'Thành ngữ - Tục ngữ - Ca dao', 'Câu đố', 'Cùng chơi các bạn ơi!'];

   return view("activities.Extendv2", compact(['elementData', 'contentArr','thumbArr', 'slide_imgArr', 'slide_nameArr', 'typeEn', 'typeVn','cnt']));

} else {
  return view("activities.Extendv2", compact(['elementData', 'contentArr','titleArr', 'cnt'])); 
}
}

public function edit(Request $request)
{
    $lesson = Lesson::find($request->lessonId);
    if ($request->has('update')) {
      foreach ($request->update as $id => $value) {
       $extElement = LanguageCulture::where('id', '=', $id)->first();
       $extElement->extensionNo = $value['extensionNo'];

       if ((integer)($value['type']) == 0) {
        $extElement->title = $value['title'];

        $caption = '';
        foreach ($value['caption'] as $captionPart) {
            Validator::make($value, [
                'caption' => 'max:200',
                ],
                [
                ])->validate();
            if (strcmp($caption, '') != 0) {
              $caption .= '|';
          }
          $caption .= $captionPart;
      }
      $extElement->slideshow_caption = $caption;

      if (array_key_exists('image', $value)) {
         $dbImages = explode('|', $extElement->slideshow_images);

         foreach ($value['image'] as $index => $image) {
            $t=time();
            $t=date("Y-m-d-H-i-s",$t);
            $extension = $image->getClientOriginalExtension();
            $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
            $fileName = 'L' . $lessonNo . '_Culture_Slideshow_' . $index . '_' . $t . '.' . $extension;

            $path = $image->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

            $dbImages[(integer)$index] = $path;
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
    Validator::make($value, [
        'title' => 'max:200',
        'composer' => 'max:200',
        'performer' => 'max:200',
        'content' => 'max:2000',
        ],
        [
        ])->validate();
    $extElement->title = $value['title'];
    $extElement->song_composer = $value['composer'];
    $extElement->song_performer = $value['performer'];
    $extElement->content = preg_replace('/\r\n/u', '|', $value['content']);

    if (array_key_exists('thumbnail', $value)) {
        $t=time();
        $t=date("Y-m-d-H-i-s",$t);
        $extension = $value['thumbnail']->getClientOriginalExtension();
        $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
        $fileName = 'L' . $lessonNo . '_Culture_Song_' .  $id .'_' . $t . '.' . $extension;

        $path = $value['thumbnail']->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

        $extElement->thumbnail = $path;
    }

    if (array_key_exists('song', $value)) {
        $t=time();
        $t=date("Y-m-d-H-i-s",$t);
        $extension = $value['song']->getClientOriginalExtension();
        $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
        $fileName = 'L' . $lessonNo . '_Culture_Song_' .  $id . '_' . $t . '.' . $extension;

        $path = $value['song']->storeAs('audio/Culture/lesson' . $lessonNo, $fileName);

        $extElement->audio = $path;
    }

    $extElement->save();
} else if ((integer)($value['type']) == 2) {
    Validator::make($value, [
        'title' => 'max:200',
        'content' => 'max:2000',
        ],
        [
        ])->validate();
    $extElement->title = $value['title'];
    $extElement->content = preg_replace('/\r\n/u', '|', $value['content']);
    $extElement->save();
} else if ((integer)($value['type']) == 3) {
    Validator::make($value, [
        'content' => 'max:2000',
        ],
        [
        ])->validate();
    $extElement->content = preg_replace('/\r\n/u', '|', $value['content']);
    $extElement->save();
} else if ((integer)($value['type']) == 4) {
    Validator::make($value, [
        'title' => 'max:200',
        'answer' => 'max:200',
        'content' => 'max:2000',
        ],
        [
        ])->validate();
    $extElement->title = $value['title'];
    $extElement->riddle_answer = $value['answer'];
    $extElement->content = preg_replace('/\r\n/u', '|', $value['content']);

    if (array_key_exists('thumbnail', $value)) {
        $t=time();
        $t=date("Y-m-d-H-i-s",$t);
        $extension = $value['thumbnail']->getClientOriginalExtension();
        $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
        $fileName = 'L' . $lessonNo . '_Culture_Riddle_Thumbnail_' .  $id . '_' . $t . '.' . $extension;

        $path = $value['thumbnail']->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

        $extElement->thumbnail = $path;
    }

    $extElement->save();
} else if ((integer)($value['type']) == 5) {
    Validator::make($value, [
        'title' => 'max:200',
        'content' => 'max:2000',
        ],
        [
        ])->validate();
    $extElement->title = $value['title'];
    $extElement->content = preg_replace('/\r\n/u', '|', $value['content']);

    if (array_key_exists('thumbnail', $value)) {
        $t=time();
        $t=date("Y-m-d-H-i-s",$t);
        $extension = $value['thumbnail']->getClientOriginalExtension();
        $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
        $fileName = 'L' . $lessonNo . '_Culture_Game_Thumbnail_' .  $id . '_' . $t  . '.' . $extension;

        $path = $value['thumbnail']->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

        $extElement->thumbnail = $path;
    }

    $extElement->save();
}
}
}

if ($request->has('insert')) {
  foreach ($request->insert as $id => $value) {

   if ((integer)($value['type']) == 0) {
    $caption = '';
    foreach ($value['caption'] as $captionPart) {
        if (strcmp($caption, '') != 0) {
            $caption .= '|';
        }
        $caption .= $captionPart;
    }

    $dbImages = array();

    foreach ($value['image'] as $index => $image) {
        $t=time();
        $t=date("Y-m-d-H-i-s",$t);
        $extension = $image->getClientOriginalExtension();
        $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
        $fileName = 'L' . $lessonNo . '_Culture_Slideshow_' . '_' . $t . $request->_token . '.' . $extension;

        $path = $image->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

        $dbImages[(integer)$index] = $path;
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
    $t=time();
    $t=date("Y-m-d-H-i-s",$t);
    $extension_img = $value['thumbnail']->getClientOriginalExtension();
    $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    $fileName_img = 'L' . $lessonNo . '_Culture_Song_' .  $id . '_' . $t . '.' . $extension_img;

    $path_img = $value['thumbnail']->storeAs('img/Culture/lesson' . $lessonNo, $fileName_img);

    $extension_au = $value['song']->getClientOriginalExtension();
    $fileName_au = 'L' . $lessonNo . '_Culture_Song_' .  $id . '_' . $t . '.' . $extension_au;

    $path_au = $value['song']->storeAs('audio/Culture/lesson' . $lessonNo, $fileName_au);

    LanguageCulture::create([
     'lesson_id' => $request->lessonId,
     'extensionNo' => (integer)($value['extensionNo']),
     'type' => 1,
     'title' => $value['title'],
     'content' => preg_replace('/\r\n/u', '|', $value['content']),
     'thumbnail' => $path_img,
     'audio' => $path_au,
     'song_composer' => $value['composer'],
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
    $t=time();
    $t=date("Y-m-d-H-i-s",$t);
    $extension = $value['thumbnail']->getClientOriginalExtension();
    $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    $fileName = 'L' . $lessonNo . '_Culture_Riddle_Thumbnail_' .  $id . '_' . $t . '.' . $extension;

    $path = $value['thumbnail']->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

    LanguageCulture::create([
     'lesson_id' => $request->lessonId,
     'extensionNo' => (integer)($value['extensionNo']),
     'type' => 4,
     'title' => $value['title'],
     'content' => preg_replace('/\r\n/u', '|', $value['content']),
     'thumbnail' => $path,
     'riddle_answer' => $value['answer'],
     ]);
} else if ((integer)($value['type']) == 5) {
    $t=time();
    $t=date("Y-m-d-H-i-s",$t);
    $extension = $value['thumbnail']->getClientOriginalExtension();
    $lessonNo = \App\Lesson::where('id', '=', $request->lessonId)->first()->lessonNo;
    $fileName = 'L' . $lessonNo . '_Culture_Game_Thumbnail_' .  $id . '_' . $t . '.' . $extension;

    $path = $value['thumbnail']->storeAs('img/Culture/lesson' . $lessonNo, $fileName);

    LanguageCulture::create([
     'lesson_id' => $request->lessonId,
     'extensionNo' => (integer)($value['extensionNo']),
     'type' => 5,
     'title' => $value['title'],
     'content' => preg_replace('/\r\n/u', '|', $value['content']),
     'thumbnail' => $path,
     ]);
}
}
}

if ($request->has('delete')) {
    foreach (explode(',', $request->delete) as $id) {
        LanguageCulture::where('id', '=', $id)->delete();
    }
}

$course = \App\Course::where('id', '=', $lesson->course_id)->first();
$course->last_updated_by = \Auth::user()->id;
$course->save();

return Redirect("/listAct".$request->all()['lessonId']);
}
}