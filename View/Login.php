<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/Login.css" />
    <script
      src="https://kit.fontawesome.com/901acbd329.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <nav class="navigation">
      <ul class="nav_ul">
        <div class="nav_ul_left">
          <li><i class="fa-solid fa-bars"></i></li>
          <li>Nhóm 1 UDPT</li>
        </div>
        <div class="nav_ul_right">
          <li><i class="fa-solid fa-sun"></i></li>

          <li>ENV<i class="fa-sharp fa-solid fa-caret-down"></i></li>

          <a href="../View/RegisterView.php"><button class="btn_LOGIN">Đăng Ký</button></a>
        </div>
      </ul>
    </nav>
    <div class="container">
      <form class="login-form" method="post" action="../Controller/index.php" name="login" >
        <h2>Login</h2>

        <input type="text" placeholder="Username" name="username" required />

        <input
          type="password"
          placeholder="Password"
          name="password"
          required
        />

        <button type="submit" name="login">Login</button>
      </form>
    </div>
  </body>
</html>
