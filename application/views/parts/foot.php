<script>

function idleLogout() {
  var t;
  window.onmousemove = resetTimer;
  window.onmousedown = resetTimer;  // catches touchscreen presses as well      
  window.ontouchstart = resetTimer; // catches touchscreen swipes as well 
  window.onclick = resetTimer;      // catches touchpad clicks as well
  window.onkeypress = resetTimer;   
  window.addEventListener('scroll', resetTimer, true); // improved; see comments

  function doLogout() {
     // your function for too long inactivity goes here
   	alert('Automatic Logout Dahil na detect ng aming system na ikaw ay walang ginagawang activity sa system na ito' )
    	window.location.href = '/new_srs_operation/site/go_logout';
    
  }

  function resetTimer() {
      clearTimeout(t);
      var minutes = 10 // 1 equal to 1 min
      var timeInterval = 60*1000*minutes
      t = setTimeout(doLogout, timeInterval);  
  }

  resetTimer()
}
idleLogout();
</script>        
    </body>
</html>