 </div>   
<!-- for open alert popup all pages active, inactive and delete start-->
<div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
            <p id="setmsg">Message</p>
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default m-b-10" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success m-b-10 m-l-5" id="popbtnok">OK</button>
      </div>
    </div>
  </div>
</div>
    <div id="search">
            <button type="button" class="close">×</button>
            <form>
                <input type="search" value="" placeholder="type keyword(s) here" />
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <!-- jquery vendor -->
       
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/jquery.nanoscroller.min.js"></script>
        <!-- nano scroller -->
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/menubar/sidebar.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/preloader/pace.min.js"></script>
        <!-- sidebar -->

        <!-- bootstrap -->

     <!--      <script src="<?php //echo HTTP_SERVER;?>assets/js/lib/data-table/buttons.dataTables.min.js"></script> -->

<!-- datatable -->
     
   



        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/weather/jquery.simpleWeather.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/weather/weather-init.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/circle-progress/circle-progress.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/circle-progress/circle-progress-init.js"></script>
  
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/sparklinechart/jquery.sparkline.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/sparklinechart/sparkline.init.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/scripts.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/common.js"></script>
        <!-- scripit init-->
    </body>
<script type="text/javascript">
 
function formsubmitsetaction(frmid,act,elemName,msg)
{
    //alert(frmid);
    document.getElementById("action").value = act;
    elem = document.getElementsByName(elemName);
    var flg = false;
    for(i=0;i<elem.length;i++){
        if(elem[i].checked)
        {
            flg = true;
            break;
        }
    }
    
    
    if(flg)
    {
        //$("#myModal").modal("show");
        $("#exampleModalLongTitle").html(act.toUpperCase());
        $("#setmsg").html(msg);
        $("#popbtnok").show();
        $('#exampleModalCenter').modal('toggle');
        $("#popbtnok").click(function(){
            document.getElementById(frmid).submit();
        });
    }
    else
    {
        //alert("Please select atlease one record");
        $(".modal-title").html("<b>WARNING</b>");
        $("#setmsg").html('Please select atlease one record');
        $("#popbtnok").hide();
        $('#exampleModalCenter').modal('toggle');
    }
}
        function selecctall(n){//on click
            if($('#selectall_'+n).prop('checked')){
                
                $('.check_'+n).each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{ 
                $('.check_'+n).each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
        }
   
</script>
</html>
