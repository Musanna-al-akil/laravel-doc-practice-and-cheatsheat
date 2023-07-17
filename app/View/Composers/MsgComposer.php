<?php
namespace App\View\Composers;
use Illuminate\View\View;

class MsgComposer
{
    public function compose(View $view): void
    {
        $view->with('count',10);
    }
}