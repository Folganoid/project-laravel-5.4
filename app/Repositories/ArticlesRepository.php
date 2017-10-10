<?php

namespace Corp\Repositories;

use Corp\Article;
use Gate;

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

        dd($data);
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