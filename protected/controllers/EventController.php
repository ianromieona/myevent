<?php
    class EventController extends Controller {
        
        public function actionIndex(){
//            Common::pre(EventDetails::getAllEvents(30),true);
            $event = EventDetails::getAllEvents(30);
            
            $obj = new stdClass();
            foreach($event as $key => $value){
                $obj->result[] = array('name'=>$value['event_name'],'details'=>$value['event_details']);
            }
            
//            Common::pre(json_encode($obj),true);
            
            $this->render('index',array('event'=>$event,'obj'=>json_encode($obj)));
            
        }
        public function actionAdd(){
            if($_POST){
                extract($_POST);
                $event = new EventDetails;
                
                $event->event_name = $name;
                $event->event_details = $details;
                $event->latitude = $lat;
                $event->longitude = $long;
                if($event->save()){
                    $community = new CommunityEvents;
                    $community->community_id = 30;
                    $community->event_id = $event->id;
                    $community->save();
                }
                $this->redirect(array('event/index'));
            }  
        }
        public function actionView($id){
            // $isUserAttends = EventDetails::isUserAttends(3,$id);
            $isUserAttends = CommunityAttending::model()->findByAttributes(array('user_id'=>1,'event_id'=>$id));
            $details = EventDetails::getEventDetails(30, $id);
           // Common::pre($isUserAttends,true);
            $this->render('view',array('id'=>$id,'details'=>$details,'isAttending'=>$isUserAttends));
        }
            
        public function actionAttend(){
            if($_POST){
                extract($_POST);
                $attend = new CommunityAttending;
//                $attend->user_id = Yii::app->user->id;
                $attend->user_id = 1;
                $attend->code = rand().rand();
                $attend->event_id = $eventId;
                if($attend->save()){
                    $community = CommunityEvents::model()->findByAttributes(array('community_id'=>$communityId,'event_id'=>$eventId));
                    $community->will_attend += 1;
                    $community->save();
                }
            }
            $this->redirect(array('event/view/'.$eventId));
        }   
    }

?>