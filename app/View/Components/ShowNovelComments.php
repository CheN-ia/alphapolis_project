<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Novel;

class ShowNovelComments extends Component
{
    /**
     * Create a new component instance.
     */

    public $novel;
    public $comments;

    public function __construct($novelId)
    {
        //
        $this->novel = Novel::findOrFail($novelId);
        // そのユーザーのコメントを取得する
        $this->comments = $this->novel->commentingUsers;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.show-novel-comments');
    }
}
