<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<!-- on other sites, if the script shouldnt be used, make sure it doesnt show anything -->
<!-- echo it -->
<?= $sLinkToScript ?? ''; ?>


<script>
$('.navLink').click( function(){
    $('.navLink').removeClass('active') // remove the active
    $('.page').hide() // hide all pages
    $(this).addClass('active')
    let sPageToShow = $(this).attr('data-showPage') // get name of page to show
    $('#'+sPageToShow).show() // show page by # ID
  });



</script>


</body>
</html>