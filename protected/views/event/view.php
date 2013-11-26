<!doctype html>
<html ng-app="myapp">
  <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.1.5/angular.min.js"></script>
    <script src="https://cdn.firebase.com/v0/firebase.js"></script>
    <script src="https://cdn.firebase.com/libs/angularfire/0.3.0/angularfire.min.js"></script>
  </head>
  <body ng-controller="MyController" class="container">
      <div class="row-fluid">
         <div class="col-md-8 panels">
            <h3><?php echo $details['event_name'];?></h3>
             <p><?php echo $details['event_details'];?></p>
             
             <div class="pull-right">
                 <?php if(!$isAttending){?>
                   <form method="post" action="<?php echo $this->createUrl('event/attend')?>">
                   <input type="hidden" name="communityId" value="<?php echo $details['community_id']?>">
                   <input type="hidden" name="eventId" value="<?php echo $details['event_id']?>">
                   <input type="submit" name="attend" class="btn btn-danger" value="Attend">
                 <?php }else { ?>
                   <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                      View QR Code
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                          </div>
                          <div class="modal-body">
                            <div id="qr"></div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                 <?php } ?>
             </div>
             <br>
                <div class="map" >  
                    <br>
                 <div id="map" style="width: 100%; height: 500px; position: relative;" class="leaflet-container leaflet-fade-anim" tabindex="0"></div>
                </div>
             <br>
             <br>
          
          </div>
        <div class="col-md-3 panels">
            <h3>Chat box</h3>
            <form class="form">
            <div id="messagesDiv">
              <div ng-repeat="msg in messages"><em>{{msg.from}}</em>: {{msg.body}}</div>
            </div>
            <input type="type" ng-model="name" placeholder="Name" value="ian" class="form-control">
            <textarea  ng-model="msg" ng-keydown="addMessage($event)" placeholder="Message..." class="form-control"></textarea>
                <br>
                </form>
        </div>
      </div>
    <script>
      var app = angular.module("myapp", ["firebase"]);
      function MyController($scope, angularFire) {
        var ref = new Firebase("https://<?php echo $id;?>tagevent.firebaseio-demo.com/");
        $scope.messages = [];
        angularFire(ref, $scope, "messages");
        $scope.addMessage = function(e) {
          if (e.keyCode != 13) return;
          $scope.messages.push({from: $scope.name, body: $scope.msg});
          $scope.msg = "";
        }
      }
    </script>
  </body>
    <script>

		var map = L.map('map').setView([<?php echo $details['latitude'];?>, <?php echo $details['longitude'];?>], 13);

		L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
		}).addTo(map);

        L.marker([<?php echo $details['latitude'];?>, <?php echo $details['longitude'];?>]).addTo(map)
            .bindPopup('<?php echo $details['event_name'];?>')
            .openPopup();

	</script>
    <script>
        $(document).ready(function(){
          <?php if($isAttending){ ?>
            $('#qr').qrcode({
              render: 'div',
              width: 200,
              height: 200,
              color: '#3a3',
              text: '<?php echo $isAttending->code;?>'
            });
          <?php } ?>
            $(".viewMap").click(function(){
                $(".map").slideToggle();
            })
        })    
    </script>
</html>