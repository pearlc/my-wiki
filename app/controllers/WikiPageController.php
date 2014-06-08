<?php

use \mywiki\PageHandler;
use \mywiki\WikiPageRenderer;

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
        $title = Input::get('title');

        $isValidTitle = Page::isValidForTitle($title);

        if (!$isValidTitle) {
            // TODO : '제목에 허용되지 않은 문자가 포함되어 있다' 라는 오류 메시지가 출력해야함
            return View::make('errors.message', [
                'title' => '잘못된 제목',
                'content' => '잘못된 문서 제목입니다. 사용할 수 없는 문자를 사용했을 수 있습니다.',
            ]);
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

        $page = $pageHandler->createPageWithInput($input);

        return Redirect::route('wiki.page.show', [$page->title]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($title)
	{
        if (!Page::isValidForTitle($title)) {
            App::abort(404);
        }

        $page = Page::with('latest_revision')->where('title', $title)->first();

        if ($page === null) {
            // TODO : 문서 이름이 바뀌어서 올바른 article을 찾지 못한 경우에는 별도의 메시지 뿌려줘야함 (예 : '문서의 경로가 변경되었을수 있습니다.' 하고 예상 문서 추천) -> 근데 보통 문서 일므을 바꾸면 포워딩을 할텐데.. 포워딩 안되도록 급격하게 문서 이름을 바꿔야 하는 경우가 있나?
            return Redirect::route('wiki.page.search', ['keyword' => $title]);
        }

        $wikiPageRenderer = new WikiPageRenderer($page);
        $wikiPageRenderer->render();

        return View::make('wiki.page.show', ['page' => $page, 'revision' => $page->latest_revision, 'text' => $wikiPageRenderer->getHtml()]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($title)
	{
        if (!Page::isValidForTitle($title)) {
            App::abort(404);
        }

        $page = Page::with('latest_revision')->where('title', $title)->first();

        if ($page === null) {
            // TODO : '보고 있는 도중에 누군가가 제목을 변경했을수도 있다'는 메시지 출력해야함
            App::abort(404);
        }

        return View::make('wiki.page.edit', ['page' => $page, 'revision' => $page->latest_revision]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $input = Input::get();

        $pageHandler = new PageHandler();

        $page = $pageHandler->updatePageWithInput($input);

        return Redirect::route('wiki.page.show', ['title' => $page->title]);

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
        $page = Page::where('title', $keyword)->first();

        // 글이 없다면 '만들기' 링크 보여주기


        return View::make('wiki.page.search', ['keyword' => $keyword, 'p' => $p, 'page' => $page]);
    }

    public function recent()
    {
        $pageChanges = PageChange::with('page')->orderBy('created_at', 'dest')->paginate(5);

        return View::make('wiki.page.recent', ['pageChanges' => $pageChanges]);
    }

    public function history($title)
    {
        if (!Page::isValidForTitle($title)) {
            App::abort(404);
        }

        $page = Page::where('title', $title)->first();

        if ($page === null) {
            // TODO : 문서 이름이 바뀌어서 올바른 article을 찾지 못한 경우에는 별도의 메시지 뿌려줘야함 (예 : '문서의 경로가 변경되었을수 있습니다.' 하고 예상 문서 추천) -> 근데 보통 문서 이름을 바꾸면 포워딩을 할텐데.. 포워딩 안되도록 급격하게 문서 이름을 바꿔야 하는 경우가 있나?
            App::abort(404);
        }

        $revisions = Revision::with('user')->where('page_id', $page->id)->get();

        return View::make('wiki.page.history', ['page' => $page, 'revisions' => $revisions]);
    }

    public function old($id)
    {
        $revision = Revision::with('page')->find($id);

        return View::make('wiki.page.old', ['page' => $revision->page, 'revision' => $revision]);
    }

}
