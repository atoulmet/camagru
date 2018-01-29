(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      preview        = document.querySelector('#preview'),
      startbutton  = document.querySelector('#startbutton'),
      upload = document.querySelector('#uploadpicture'),
      submitupload = document.querySelector('#uploadsubmitbutton'),
      img1 = document.querySelector('#img1'),
      img2 = document.querySelector('#img2'),
      img3 = document.querySelector('#img3'),
      width = 320,
      height = 0,
      uploadData = 0,
      imgselected = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    },
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function addMinipic(data) {
    var pic = document.createElement("IMG");
    pic.setAttribute("src", data);
    pic.setAttribute("height", "70em");
    pic.setAttribute("width", "70em");
    var div = document.getElementById('side');
    div.insertBefore(pic, div.childNodes[0]);
  }

  function save_picture(data) {
    var picData = data.replace("data:image/png;base64,", "");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "savepic.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("pic="+encodeURIComponent(picData));
    document.querySelector('#dl-btn').href = data; //Permet de télécharger l'image
}

  function mergePicAndDisplay(pic) {
    var picData = pic.replace("data:image/png;base64,", "");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "mergepic.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("pic="+encodeURIComponent(picData)+"&img="+imgselected);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        response = "data:image/png;base64,"+response;
        image = new Image();
        image.src = response;
        image.onload = function() {
          canvas.getContext('2d').drawImage(image, 0, 0, width, height);
          canvas.toDataURL('image/png');
          save_picture(response);
          addMinipic(response);
          }
      }
    }
  }

  img1.addEventListener('click', function(ev){
    imgselected = 1;
    var img = document.getElementById("img1");
    img.setAttribute("style", "background-color:#edd15a");
    img = document.getElementById("img2");
    img.setAttribute("style", "background-color:#f2f2f2");
    img = document.getElementById("img3");
    img.setAttribute("style", "background-color:#f2f2f2");
    ev.preventDefault();
  }, false);

  img2.addEventListener('click', function(ev){
    imgselected = 2;
    var img = document.getElementById("img2");
    img.setAttribute("style", "background-color:#edd15a");
    img = document.getElementById("img1");
    img.setAttribute("style", "background-color:#f2f2f2");
    img = document.getElementById("img3");
    img.setAttribute("style", "background-color:f2f2f2");
    ev.preventDefault();
  }, false);

  img3.addEventListener('click', function(ev){
    imgselected = 3;
    var img = document.getElementById("img3");
    img.setAttribute("style", "background-color:#edd15a");
    img = document.getElementById("img2");
    img.setAttribute("style", "background-color:#f2f2f2");
    img = document.getElementById("img1");
    img.setAttribute("style", "background-color:#f2f2f2");
    ev.preventDefault();
  }, false);

  function takepicture(uploaded) {
    var newcanvas = document.createElement('canvas');
    newcanvas.width = width;
    newcanvas.height = height;
    canvas.width = width;
    canvas.height = height;
    newcanvas.id = "newcanvas";
    var warning = document.getElementById('warning');
    var notifdiv = document.getElementById('notifdiv');
    if (imgselected !== 0)
    {
     while (warning.firstChild)
        warning.removeChild(warning.firstChild);
    if (uploaded === 0) {
      newcanvas.getContext('2d').drawImage(video, 0, 0, width, height);
      var data = newcanvas.toDataURL('image/png');
      mergePicAndDisplay(data);
    }
    else {
      var image = new Image();
      image.src = uploadData;
      image.onload = function() {
        newcanvas.getContext('2d').drawImage(image, 0, 0, width, height);
        var pic = newcanvas.toDataURL('image/png');
        mergePicAndDisplay(pic);
      }
    }
  }
    else
      notiferror("NoFilter");
  }

  submitupload.addEventListener('click', function(ev) {
    if (uploadData == 0)
      notiferror("NoUpload");
    else
      takepicture(1);
  }, false);

  upload.addEventListener('change', function(e) {
    var file = this.files[0];
    var imageType = /image.*/;
    if (file === undefined)
      notiferror(FileType);
    var extension = file.name.split('.').pop();
    if (file.type.match(imageType) && file.size < 1500000) 
    {
       var reader = new FileReader();
      reader.addEventListener('load', function() {
      uploadData = reader.result;
    }, false);
    reader.readAsDataURL(file);
  }
  
  else if (file.size >= 1500000)
    notiferror("FileSize");
  else if (extension !== "pnj" && extension !== "jpg" && extension !== "jpeg")
    notiferror("FileType");
}, false);

  startbutton.addEventListener('click', function(ev){
    if (streaming == true)
      takepicture(0);
    else
      notiferror(camera);
    ev.preventDefault();
  }, false);

})();
// var notifdiv = document.getElementById('notifdiv');
function notiferror(msg)
{
  var warning = document.getElementById('warning');
  var notifdiv = document.createElement("DIV");
  notifdiv.setAttribute("id", "notifdiv");
  notifdiv.setAttribute("style", "color:red");
  if (msg == "NoFilter")
    var notif = document.createTextNode("Veuillez sélectionner un filtre!");
  else if (msg == "camera")
    var notif = document.createTextNode("Veuillez autoriser l'utilisation de votre caméra!");
  else if (msg == "NoUpload")
    var notif = document.createTextNode("Veuillez uploader un fichier valide avant de fusionner!");
  else if (msg == "FileSize")
    var notif = document.createTextNode("Veuillez uploader un fichier de moins de 1,5 Mo");
  else if (msg == "FileType")
    var notif = document.createTextNode("Veuillez uploader un fichier png, jpg ou jpeg");
  notifdiv.appendChild(notif);
  warning.appendChild(notifdiv);
}