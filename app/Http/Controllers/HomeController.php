<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactInfo;
use App\Jobs\SendReportAbuse;
use App\Models\Banner;
use App\Models\Cause;
use App\Models\NewsLetter;
use App\Models\Posts;
use App\Models\Skill;
use App\Models\Suitable;
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

        $data['all_causes'] = Cause::getCauses('all');
        $data['all_skills'] = Skill::getSkills('all');
        $data['all_suitables'] = Suitable::getSuitables('all');
        $data['dates'] = [
            ['name' => 'All Dates', 'id' => 'all_date'],
            ['name' => 'Tomorrow', 'id' => 'tomorrow'],
        ];
        $data['openings'] = [
            ['name' => '1-10', 'id' => '1-10'],
            ['name' => '11-20', 'id' => '11-20'],
            ['name' => '21-30', 'id' => '21-30'],
            ['name' => 'Above 30', 'id' => '31-9999'],
        ];

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
            'email' => ['required', 'string', 'email', 'max:191']
        ]);
        $received = NewsLetter::where('email', $request->get('email'))->first();
        if (isset($received)) {
            return response()->json(['errors' => ['email' => ['The email has already been subscribed.']]], 422);
        }
        return new SaveNewsLetterResponse('save');
    }
    /***@POST_NEWSLETTER */

    /***@POST_REPORT_FEEDBACK
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function responsePostReportAbuse(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191'],
            'reason' => ['required', 'string', 'max:800'],
        ]);
        $this->dispatch(new SendReportAbuse($request->all()));
        return response()->json(['success' => true, 'msg' => 'The report abuse information was sent!.']);
    }
    /***@POST_REPORT_FEEDBACK */

}
