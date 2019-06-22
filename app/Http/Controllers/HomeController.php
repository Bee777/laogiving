<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactInfo;
use App\Models\Banner;
use App\Models\Cause;
use App\Models\Posts;
use App\Responses\Home\PostsResponse;
use App\Responses\Home\SinglePostsResponse;
use App\Responses\SaveNewsLetterResponse;
use App\Traits\DefaultData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Helpers;

class HomeController extends Controller
{
    use DefaultData;
    public $rootView = 'main.general';

    /**
     * @Responses and Actions api|web
     */

    /***@SinglePostsResponse *
     * @param Request $request
     * @param $type
     * @param $id
     * @return SinglePostsResponse
     */

    public function responsePostsSingle(Request $request, $type, $id): SinglePostsResponse
    {
        return new SinglePostsResponse(['rootView' => $this->rootView], $type, $id);
    }
    /***@SinglePostsResponse * */


    /***@PostsResponse *
     * @param Request $request
     * @param $type
     * @return PostsResponse
     */
    public function responsePosts(Request $request, $type): PostsResponse
    {
        return new PostsResponse(['rootView' => $this->rootView], $type);
    }
    /***@PostsResponse * */

    /**
     * @Responses and Actions api|web
     */
    /**
     * @TODO home guest or all users  can view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Helpers::isAjax($request)) {
            return response()->json(['data' => $this->getHomeData($request)]);
        }
        return view((string)$this->rootView, $this->getDefaultData($request));
    }

    /***@Get Home Data
     * @param $request
     * @return array
     */
    public function getHomeData($request): array
    {
        $data = [];
        $data['banners'] = Banner::getBanners(8);
        $data['latest_news'] = Posts::getPosts('news', 3);
        $data['states'] = $this->getStates();
        $data['causes'] = Cause::getCauses(14);
        return $data;
    }
    /***@Get Home Data */

    /***@POST_CONTACTINFO
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function responsePostContactInfo(Request $request): JsonResponse
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'message' => ['required', 'string'],
        ]);
        $this->dispatch(new SendContactInfo($data));
        return response()->json(['success' => true, 'msg' => 'The contact information was sent!.']);
    }
    /***@POST_CONTACTINFO */

    /***@POST_NEWSLETTER
     * @param Request $request
     */
    public function responsePostNewsLetter(Request $request)
    {
       $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191', 'unique:news_letters'],
        ]);
        return new SaveNewsLetterResponse('save');
    }
    /***@POST_NEWSLETTER */
}
