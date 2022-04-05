               <script>
                 
                  //    setInterval(function()
                  //   {   
                  //          var ctr = 5;
                  //       // $.ajax({
                  //       //   type:"post",
                  //       //   url:"myurl.html",
                  //       //   datatype:"html",
                  //       //   success:function(data)
                  //       //   {
                  //       //       //do something with response data
                  //       //   }
                  //       // });
                  //       ctr = ctr + 5;
                  //       $('#constat').text(ctr);
                  //   }, 5000);//time in milliseconds
                  //       });

                  // var counter = 0;
                  //   setInterval(function () {
                  //     ++counter;
                  //   }, 1000);
                 
                </script>
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php
                            if(isset($page_title))
                                echo $page_title;
                        ?>
                        <?php
                            if(isset($page_subtitle)){
                                echo "
                                    <small>
                                        ".$page_subtitle."
                                    </small>
                                ";
                            }
                        ?>
                        <span id="constat"></span>
                    </h1>

                    
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php 
                        if(isset($code))
                            echo $code; 
                    ?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php
            if(isset($js))
                echo $js;
        ?> 
        <?php 
            if(isset($add_js)){
                if(is_array($add_js)){
                    foreach ($add_js as $path) {
                        echo '<script src="'.base_url().$path.'" type="text/javascript"  language="JavaScript"></script>';
                    }
                }
                else
                     echo '<script src="'.base_url().$add_js.'" type="text/javascript"  language="JavaScript"></script>';
            }
        ?>

        <script>
            // var counter = 0;
               //     var div = document.getElementById('constat');
               //     setTimeout(function(){
                       
               //         var st = setInterval(function(){
             //           var count = ++counter;
          //              var url = '<?php echo base_url(); ?>operation/check_con';
          //                  $.ajax({
                           //     type:'GET',
                            //    url:url,
                           //     cache:false,
                           //     success:function(data){
                          //          var myObj = JSON.parse(data);
                                    //alert(myObj.msg);
                                    //if(myObj.msg == "connected")
                                       // div.innerHTML = "<span style='color:green'>Connected</span>";
                                    //if(myObj.msg == "disconnected")
                                       // div.innerHTML = "<span style='color:red'>Disconnected</span>";
                                    // rMsg('Data deleted','success');
                                    // window.location = page_url;         
                            //    },
                          //      error:function(){
                                 //   rMsg('Oops. Somethings wrong. Contact IS Department','error');
                       //         }
                      //      });

                   //    // div.innerHTML = ++counter;
                       
                 //     },10000)
                 //   },3000);
        </script> 