<!DOCTYPE html>
<html>
  <head>
  
   </head>
  <body onLoad="init();">
    <h2>Take a snapshot of Client from the current Video Stream</h2>
   Click on the Start WebCam Button first.
     <p>
    <button onClick="startWebcam();">Start WebCam</button>
    <button onClick="stopWebcam();">Stop WebCam</button> 
    <button onClick="snapshot();">Take Photo & Save</button> 
    </p>
    <video onclick="snapshot(this);" width=200 height=200 id="video" controls autoplay></video>
  <p> Screenshots : <p>
        
      <form method="post" accept-charset="utf-8" name="form1">
      <canvas id="myCanvas" width="200" height="200"></canvas>  
      
       <input name="hidden_data" id='hidden_data' type="hidden"/>
       
       <input name="client_name" id='client_name' type="hidden"/>
                  
      
      </form>
      
           
  </body>
  <script>
  
   
      //--------------------
      // GET USER MEDIA CODE
      //--------------------
          navigator.getUserMedia = ( navigator.getUserMedia ||
                             navigator.webkitGetUserMedia ||
                             navigator.mozGetUserMedia ||
                             navigator.msGetUserMedia);

      var video;
      var webcamStream;

      function startWebcam() {
        if (navigator.getUserMedia) {
           navigator.getUserMedia (

              // constraints
              {
                 video: true,
                 audio: false
              },

              // successCallback
              function(localMediaStream) {
                  video = document.querySelector('video');
                 video.src = window.URL.createObjectURL(localMediaStream);
                 webcamStream = localMediaStream;
				 				 
              },

              // errorCallback
              function(err) {
                 console.log("The following error occured: " + err);
              }
           );
        } else {
           console.log("getUserMedia not supported");
        }  
      }

      function stopWebcam() {
	       webcamStream.stop();
		 
      }
      //---------------------
      // TAKE A SNAPSHOT CODE
      //---------------------
      var canvas, ctx;

      function init() {
        // Get the canvas and obtain a context for
        // drawing in it
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext('2d');
		 }

      function snapshot() {
         // Draws current image from the video element into the canvas
        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		
		
		//console.log(ctx.getImageData(50, 50, 100, 100));
		
		    // var canvas = document.getElementById("canvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
				
				document.getElementById('client_name').value = 'dinesh panajkar';				
				
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_photo.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Succesfully uploaded');
                    }
                };
 
                xhr.onload = function() {
 
                };
                xhr.send(fd);
			
		//below is to clear canvas rectangle
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		
		//var image = document.createElement("img");
	//image.src = canvas.toDataURL('image/png');
	
/*	

$.ajax({
url: 'upload_photo.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "HTML",
//data: new FormData(this), //Data sent to server, a set of key/value pairs (i.e. form fields and values	

data: {
	 img : canvas.toDataURL('image/png')	
	  },

contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   
{
$("#myform").html(data);
}

});*/
	
	
	      }



  </script>
    
</html>