<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 5. 25.
 * Time: 오후 5:13
 */


class Revision extends Eloquent {

    protected $fillable = ['id', 'page_id', 'text', 'comment', 'user_id', 'ip', 'deleted', 'bytes', 'parent_revision_id', 'sha1'];

    public function page()
    {
        return $this->belongsTo('Page');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}
