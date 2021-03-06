<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permisologia\Permission;
use App\User;
use App\Models\Assistance;

class RouteController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Vista principal que renderizara vuejs
     * @return view
     */
    function index(Request $request)
    {
        if ($request->path() == '/') {
            $assistance = Assistance::where('event_id', 1)
            ->where('user_id', \Auth::user()->id)
            ->where('finish_at', null)
            ->first();
            if ($assistance) return redirect('/control-de-asistencias/' . $assistance->course_id);
        }
        return view('index');
    }

    /**
     * Envia a la vista datos.
     * @return Array
     */
    public function dataForTemplate()
    {
        if (! \Auth::check()) return response()->json();

        if (request()->rs == 'ras') {
            $user = \Auth::user();
            $all = [
                'L' => [
                    'Lg' => '/img/starslogo.png',
                    'Lm' => config('frontend.logo_mini')
                ],
                'user' => [
                    'fullName' => $user->fullName(),
                    'logoPath' => $user->getLogoPath(),
                    'from' => $user->created_at->toFormattedDateString()
                ],
                'foot' => [
                    'y' => date('Y'),
                    'credits' => config('frontend.credits'),
                    'version' => config('frontend.version')
                ]
            ];
        } elseif (request()->rs == 'p') {
            $all = \Auth::user()->permissionsOfUser();
        }
        return response()->json($all);
    }

    /**
     * Verifica si puedo acceder a esa vista.
     * @return Boolean
     */
    public function canPermission(Request $request)
    {
        $whiteList = ['error', 'profile'];
        if (in_array($request->p, $whiteList)) return response()->json(true);
        $separated = explode('.', $request->p);
        $module = $separated[0];
        $action = $separated[1];
        if (\Auth::user()->iCan($module, $action)) return response()->json(true);
        if (strpos($request->p, '-') > 0) {
            $modules_separated = explode('-', $request->p);
            $lastArray = array_pop($modules_separated);
            $separated = explode('.', $lastArray);
            $module = $separated[0];
            $action = $separated[1];

            if (\Auth::user()->iCan($module, $action)) return response()->json(true);

            foreach ($modules_separated as $ms) {
                if (\Auth::user()->iCan($ms, $action)) return response()->json(true);
            }
        }

        return response()->json(false);
    }

    /**
     * Inicia la sessión con cualquier usuario que llegue como parametro.
     * @return Redirect
     */
    public function initSession($id)
    {
        if (\Auth::user()->id != 1 && !\Auth::user()->iCan('user', 'sesion_stars')) return abort(401, 'Unauthorized.');
        \Auth::loginUsingId($id);
        return redirect()->to('/');
    }
}
