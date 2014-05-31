<?php

use \mywiki\PageHandler;

class WikiPageController extends \BaseController {

    protected $table = 'pages';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        return View::make('wiki.page.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $title = Page::sanitizeForTitle(Input::get('title'));

        if ($title === null || $title === '') {
            return Redirect::route('wiki.page.recent');
        }

        return View::make('wiki.page.create', ['title' => $title]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Input::get();

        if (!Page::isValidForCreation($input)) {
            return Redirect::back()->withErrors(Page::getErrors())->withInput();
        }

        $pageHandler = new PageHandler();

        $pageHandler->createPageWithInput($input);

        return Redirect::route('wiki.page.show', [$input['title']]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//

        return 'show 뷰 입니다. '.$id. ' 문서를 보여줘야함';
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function search()
    {
        $keyword = Input::get('keyword');
        $p = Input::get('p', 1);


        // TODO : 검색결과 페이징
        // TODO : 페이지 가져오는 부분 최적화 (캐싱?)
        // TODO : 전달된 keyword를 제목에 들어가는 형태로 변형 (특수문자 제거등 : 이걸 어느 메서드에 넣어야 하나?)




        // 글이 있다면 바로가기 링크 보여주기


        // 글이 없다면 '만들기' 링크 보여주기


        return View::make('wiki.page.search', ['keyword' => $keyword, 'p' => $p]);
    }

    public function recent()
    {
        // TODO : 페이징
        return View::make('wiki.page.recent');
    }

}
