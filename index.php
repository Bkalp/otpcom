<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            color: #333;
            line-height: 1.6;
            font-family: 'Poppins', sans-serif;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 400px;
            margin: auto;
            padding: 40px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            margin-top: 10%;
        }

        /* Form Styles */
        .form-title {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 14px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px 45px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #6c63ff;
        }

        input::placeholder {
            color: #aaa;
        }

        /* Recover Password */
        .recover {
            text-align: right;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .recover a {
            color: #6c63ff;
            text-decoration: none;
        }

        .recover a:hover {
            text-decoration: underline;
        }

        /* Sign In Button */
        .btn {
            font-size: 1.1rem;
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 100%;
            background: #6c63ff;
            color: white;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn:hover {
            background: #5a54d8;
        }

        /* Social Login Section */
        .or {
            text-align: center;
            margin: 20px 0;
            font-size: 0.9rem;
            color: #666;
        }

        .icons {
            display: flex;
            justify-content: space-between;
            margin: 0 auto;
            width: 150px;
        }

        .icons a {
            text-decoration: none;
        }

        .icons i {
            font-size: 1.5rem;
            color: #6c63ff;
            transition: 0.3s ease;
        }

        .icons i:hover {
            color: #333;
        }

        /* Links for Sign Up */
        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            color: #6c63ff;
            font-weight: bold;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      <p class="or">
        ----------or--------
      </p>
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="register.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
          <p class="recover">
            <a href="#">Recover Password</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">
          ----------or--------
        </p>
         <!-- Social Buttons -->
    <div class="icons">
        <a href="https://accounts.google.com" target="_blank">
            <i class="fab fa-google"></i>
        </a>
        <a href="https://www.facebook.com" target="_blank">
            <i class="fab fa-facebook"></i>
        </a>
    </div>

    <div class="links">
        <p>Don't have an account yet?</p>
        <button id="signUpButton">Sign Up</button>
    </div>
</div>
      <script src="script.js"></script>
</body>
</html>