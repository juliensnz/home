<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeviceController extends Controller
{
    protected $scenarios = [
        'living_room' => ['a', 'b'],
        'dress_room'  => ['c'],
        'bed_room'    => ['d']
    ];

    /**
     * @Route("/device/{code}/{action}", name="device_on")
     */
    public function deviceAction(Request $request, $code, $action)
    {
        $codes = array_map(function ($value) use ($action) {
            return $value . '_' . $action;
        }, $this->scenarios[$code]);

        exec(sprintf('python %s/../send.py %s', $this->getParameter('kernel.root_dir'), implode(' ', $codes)));
        return new JsonResponse();
    }
}
