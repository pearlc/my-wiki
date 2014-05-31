<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 5. 18.
 * Time: 오후 9:02
 */

class PageChange extends Eloquent {

    // type 이 취할수 있는 값
    const PC_EDIT = 0;
    const PC_NEW = 1;
    const PC_MOVE = 2;
    const PC_LOG = 3;
    const PC_MOVE_OVER_REDIRECT = 4;
    const PC_EXTERNAL = 5;


    protected $fillable = ['id', 'page_id', 'user_id', 'namespace', 'title', 'comment', 'bot', 'type', 'ip', 'old_len', 'new_len', 'deleted'];

    /**
     *
     * type 의 값들
     *
     * 0 (RC_EDIT) — edit of existing page
     * 1 (RC_NEW) — new page
     * 2 (RC_MOVE) — move (obsolete)
     * 3 (RC_LOG) — log action (introduced in MediaWiki 1.2)
     * 4 (RC_MOVE_OVER_REDIRECT) — move over redirect (obsolete)
     * 5 (RC_EXTERNAL) — An external recent change. Primarily used by Wikidata
     *
     *
     *
     */


    public function user()
    {
        return $this->belongsTo('User');
    }

    public function page()
    {
        return $this->belongsTo('Page');
    }
}