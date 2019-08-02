<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Clock;
use App\Models\Area;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function welcome()
    {
        $data = array(
            'areas' => Area::all()
        );
        return view('welcome', $data);
    }

    public function clockHandler(Request $request){

        if(isset($request->action)){
            $data = array(
                'action' => $request->action
            );

            if($request->action == 'setClock'){
                return $this->setClock($request);
            } else if($request->action == 'getClock'){
                return $this->getClock($request);
            } else if($request->action == 'setArea'){
                return $this->setArea($request);
            } else if($request->action == 'getArea'){
                return $this->getArea($request);
            } else if($request->action == 'getUser'){
                return $this->getUser($request);
            } else if($request->action == 'setUser'){
                return $this->setUser($request);
            } else {
                return array('error' => 'invalid action');
            }
        } else {
            return array('error' => 'missing action');
        }
    }

    /*
    public function setUser($params){
        $user = User::find($params->user_id);

        $user->area_id = $params->area_id;
        $user->save();
        return $user;
    }
*/
    public function setClock($params){

        $clockId = 0;
        if(isset($params->clockId) || isset($params->id) || isset($params->clock_id)){
            if(isset($params->clockId) ){
                $clockId = $params->clockId;
            } else if(isset($params->clock_id) ){
                $clockId = $params->clock_id;
            } else {
                $clockId = $params->id;
            }
            if($clockId > 0){
                $clock = Clock::find($clockId);
            } else {
                $clock = new Clock;    
            }
        } else {
            $clock = new Clock;
        }
        if(isset($params->user_id)){
            $clock->user_id = $params->user_id;
        }

        if(isset($params->area_id)){
            $clock->area_id = $params->area_id;
        }

        if(isset($params->user_id) && isset($params->area_id)){
            $this->setUser($params);
        }

        if(isset($params->coordinator_id)){
            $clock->coordinator_id = $params->coordinator_id;
        }
        if(isset($params->status)){
            $clock->status = $params->status;
        } else {
            $clock->status = 'active';
        }
        if(isset($params->clock_start)){
            if($params->clock_start == 'now'){
                $clock->clock_start = date('Y-m-d H:i:s');
            } else {
                $clock->clock_start = $params->clock_start;
            }
        }
        if(isset($params->clock_finish)){
            if($params->clock_finish == 'now'){
                $clock->clock_finish = date('Y-m-d H:i:s');
                $t1 = strtotime( $clock->clock_start );
                $t2 = strtotime( date('Y-m-d H:i:s') );
                $diff = $t2 - $t1;
                $clock->hours = $diff / ( 60 * 60 );

            } else {
                $clock->clock_finish = $params->clock_finish;
                $t1 = strtotime( $clock->clock_start );
                $t2 = strtotime( date('Y-m-d H:i:s') );
                $diff = $t2 - $t1;
                $clock->hours = $diff / ( 60 * 60 );
            }
        }

        if(!isset($params->clock_start) && !isset($params->clock_finish)){
            $clock->clock_start = date('Y-m-d H:i:s');
            
        }
        if($clockId == 0){
           if(isset($params->created_at)){
                $clock->created_at = $params->created_at;
            } else {
                $clock->created_at = date('Y-m-d H:i:s');
            }
        }

        $clock->save();
        return $clock;

    }

    public function getClock($params){

        if(isset($params->clockId)){
            $clockData = Clock::find($params->clockId);
        } 

        if(isset($params->userId)){
            $clockData = Clock::where('user_id', $params->userId)->get();
        } 

        if(isset($params->coordinatorId)){
            $clockData = Clock::where('coordinator_id', $params->coordinatorId)->get();
        } 

        return $clockData;
    }


    public function setArea($params){

        $areaId = 0;
        if(isset($params->areaId) || isset($params->id) || isset($params->area_id)){
            if(isset($params->areaId) ){
                $areaId = $params->areaId;
            } else if(isset($params->area_id) ){
                $areaId = $params->area_id;
            } else {
                $areaId = $params->id;
            }
            if($areaId > 0){
                $area = Area::find($areaId);
            } else {
                $area = new Area;    
            }
        } else {
            $area = new Area;
        }
        if(isset($params->name)){
            $area->name = $params->name;
        }
        if(isset($params->coordinator_id)){
            $area->coordinator_id = $params->coordinator_id;
        }
        if(isset($params->subcoordinator_id)){
            $area->subcoordinator_id = $params->subcoordinator_id;
        }

        $area->save();

        return $area;
    }

    public function getArea($params){
        $query = Area::query();

        if(isset($params->name)){
            $query = $query->where('name', $params->name);
        }
        if(isset($params->name)){
            $query = $query->where('name', $params->name);
        }

        $query->orderBy('name');
        
        return $query->get();
    }


    public function getUser($params){
        $query = User::query();

        if(isset($params->id)){
            $query = $query->where('id', $params->id);
        }
        if(isset($params->type)){
            $query = $query->where('type', $params->type);
        }

        if(isset($params->area_id)){
            $query = $query->where('area_id', $params->area_id);
        }
        if(isset($params->email)){
            $query = $query->where('email', $params->email);
        }

        $query->orderBy('id');
        
        return $query->get();
    }

    public function setUser($params){

        //print_r($params);
        if(isset($params->id)){
            $user = User::find($params->id);
        } else if(isset($params->user_id)){
            $user = User::find($params->user_id);
        } else if(isset($params->email)){
            $userEmail = User::where('email', $params->email)->first();
            if(sizeof($userEmail) > 0){
                $user = User::find($userEmail->id);
            } else {
                $user = new User;
            }
        } else {
            $user = new User;    
        }
      
        if(isset($params->firstname)){
            $user->firstname = $params->firstname;
        }
        if(isset($params->lastname)){
            $user->lastname = $params->lastname;
        }
        if(isset($params->lastname)){
            $user->lastname = $params->lastname;
        }
        if(isset($params->phone)){
            $user->phone = $params->phone;
        }
        if(isset($params->age)){
            $user->age = $params->age;
        }
        if(isset($params->area)){
            $user->area = $params->area;
        }
        if(isset($params->email)){
            $user->email = $params->email;
        }
        if(isset($params->user_type)){
            $user->user_type = $params->user_type;
        }
        if(isset($params->user_type_id)){
            $user->user_type_id = $params->user_type_id;
        }
        if(isset($params->area_id)){
            $user->area_id = $params->area_id;
        }
        if(isset($params->password) && !empty($params->password)){
            $user->password = bcrypt($params->password);
        } 
        $user->save();

        return $user;
    }

    /**
     * List all pending times by Area ID
     * @param  int $area_id Area ID
     * @return array          
     */
    public function getPedingTimesByArea($area_id)
    {   
        return Clock::where(['area_id' => $area_id, 'status' => 'pending approval'])->get();        
    }

    /**
     * Approves clock with pending approval status
     * @param  int $clock_id id
     * @return [type]           [description]
     */
    public function approveClock($clock_id)
    {
        Clock::where(['id' => $clock_id, 'status' => 'pending approval'])->update(['status' => 'approved']);
        return ['status' => 'ok'];
    }

    public function rejectClock($clock_id)
    {
        Clock::where(['id' => $clock_id, 'status' => 'pending approval'])->update(['status' => 'rejected']);
        return ['status' => 'ok'];
    }

    
    public function setTicket($params){

        if(isset($params->id)){
            $ticket = Ticket::find($params->id);
        } else if(isset($params->ticket_id)){
            $ticket = Ticket::find($params->ticket_id);
        } else {
            $ticket = new Ticket;    
        }
      
        if(isset($params->user_id)){
            $ticket->user_id = $params->user_id;
        }
        if(isset($params->coordinator_id)){
            $ticket->coordinator_id = $params->coordinator_id;
        }
        if(isset($params->status)){
            $ticket->status = $params->status;
        }
        $ticket->save();

        return $ticket;
    }

    public function getTicket($params){
        $query = Ticket::query();

        if(isset($params->id)){
            $query = $query->where('id', $params->id);
        }
        if(isset($params->user_id)){
            $query = $query->where('type', $params->user_id);
        }

        if(isset($params->coordinator_id)){
            $query = $query->where('coordinator_id', $params->coordinator_id);
        }
        if(isset($params->status)){
            $query = $query->where('status', $params->status);
        }

        return $query->get();
    }

}
