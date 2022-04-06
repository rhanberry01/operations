    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="site/go_login" method="post" id="login-form">
                <div class="body bg-gray">
                    <span id="err"></span>
					 <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-navicon"></i></span>
                             <select name ="branch" class="form-control rOkay" id = "branch">
								 <option value='-1'>Select Branch</option>
								 <?php
                                 $branch_op = BRANCH_OP;
								 $sql = "SELECT * FROM 0_branch where branch_code ='".$branch_op."' ";
								 $query = mysql_query($sql) or die(mysql_error());
								while($row = mysql_fetch_array($query))
								 {
									echo "<option value='".$row['branch_code']."'>".htmlentities($row['description'])."</option>";
								 }
								 ?></select>
							 </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="username" class="form-control rOkay" ro-msg='Error! Username must not be empty.' placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                         <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control rOkay" ro-msg='Error! Password must not be empty.' placeholder="Password"/>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button id='login-btn' class="btn bg-olive btn-block">Submit</button>
                    <!-- <p><a href="#">I forgot my password</a></p> -->
                    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
                </div>
            </form>
        </div>
    </body>
    <?php
        echo $js;
    ?>