$(document).ready(function () {
    var errorCatch=false;
        try
        {
          var btnLogT=document.getElementById('btnLogT');
          var cordinates=document.getElementById('cordinates');
          var logbtn=document.getElementById('logbtn');
          var loadimg=document.getElementById('loadimg');

          var cordinatesLat=document.getElementById('clat');
          var cordinatesLon=document.getElementById('clon');
          cordinatesLat.value="not defined";
          cordinatesLon.value="not defined";

          cordinates.innerHTML="not defined";
          loadimg.style.display = 'none';

          btnLogT.onclick=function() {
            //request location
            const success=(position)=>{
                const latitude=position.coords.latitude;
                const longitude=position.coords.longitude;
                cordinates.innerHTML='latitude: '+latitude+" longitude: "+longitude;
                cordinatesLat.value=latitude;
                cordinatesLon.value=longitude;
            }
            const error=()=>{
                alert('Could not access your location..');
            }
            navigator.geolocation.getCurrentPosition(success,error);

          };
          logbtn.onclick=function () {
            loadimg.style.display = '';
          };
          
        } catch (error) {
          errorCatch=true;
        }
    });