<?php 

setcookie('user',"",time()-3600,"/");
setcookie('name',"",time()-3600,"/");

echo "You have been logged out. Redirecting you to the login page.....";

sleep(2);

echo "<a href='index.html'>Click here </a> if you have not been redirected";

header("Location: index.html");

 ?>