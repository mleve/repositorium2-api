<ul class="nav nav-pills" >
  <li class="active">
    <a href="#" class="resourceLink" id="docResource">
      <span class="badge pull-right">42</span>
      My documents
    </a>
  </li>
  <li>
    <a href="#" class="resourceLink" id="critResource">
      <span class="badge pull-right">16</span>
      My criteria
    </a>
  </li>
  <li>
    <a href="#" class="resourceLink" id="appResource">
      <span class="badge pull-right">16</span>
      My Apps
    </a>
  </li>
</ul>
<div id="resourceContainer">
</div>

<script type="text/javascript">
  $('.resourceLink').on('click',function(event){
    event.preventDefault();
    //alert("Hola");
    $('li').removeClass('active');
    $(this).parent().addClass('active');
    $('#resourceContainer').html('<img src="img/loading2.gif" class="img-responsive loading-img text-center" />');
    if($(this).attr('id') === 'docResource'){
      $('#resourceContainer').html('<p> Hola</p>');
    }


  });
</script>