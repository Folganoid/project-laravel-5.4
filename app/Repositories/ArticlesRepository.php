<?php

namespace Corp\Repositories;

use Corp\Article;
use Gate;
use Illuminate\Support\Facades\Config;
use Image;

class ArticlesRepository extends Repository
{

    public function __construct(Article $articles)
    {
        $this->model = $articles;
    }

    public function one($alias, $attr = []) {

        $article = parent::one($alias, $attr);

        if($article && !empty($attr)) {
            $article->load('comment');
            $article->comment->load('user');
        }

     return $article;

    }

    public function addArticle($request) {

        if(Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        if($this->one($data['alias'], FALSE)) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();

            return ['error' => 'Данный псевдоним уже используется'];
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()) {

                $str = str_random(8);
                $obj = new \stdClass;

                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->fit(Config::get('settings.image')['width'], Config::get('settings.image')['height'])->
                    save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->path);

                $img->fit(Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['height'])->
                save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->max);

                $img->fit(Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['height'])->
                save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->mini);

                $data['img'] = json_encode($obj);
                $this->model->fill($data);

                if($request->user()->article()->save($this->model)) {
                    return ['status' => 'Материал добавлен'];
                }

            }
        }
    }

    public function transliterate($string) {
        $str = mb_strtolower($string, 'UTF-8');

        $leter_array = [

            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г',
            'd' => 'д',
            'e' => 'е, э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и',
            'ji' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'h' => 'х',
            'c' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'sch' => 'щ',
            '' => 'ъ',
            'i' => 'ы',
            'y' => 'ь',
            'ju' => 'ю',
            'ja' => 'я',

        ];

        foreach ($leter_array as $leter => $kyr) {
            $kyr = explode(',', $kyr);

            $str = str_replace($kyr, $leter, $str);
        }

        // A-Za-z0-9-
        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);

        $str = trim($str, '-');

        return $str;

    }

}