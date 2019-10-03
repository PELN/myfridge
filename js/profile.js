$(document).ready(function () {
    $('.page').hide()    
    $('#fridge').fadeIn(1000);
});

$('#searchResults').hide();
$(document).on('input', '#txtSearch', function(){
    //check if name is empty
    var name = $('#txtSearch').val();
        if (name == '') {
        //show nothing in html (otherwise whole list will be shown)
        $('#searchResults').html('');
        $('#searchResults').hide();
    }

    //else if name is not empty, show the name
    else{
    $.ajax({
        method: "GET",
        url: "apis/api-search-for-food-item.php",
        cache: false,
        data: {
            txtSearch: name
        }
    }).done(function(response){
        //set as .html -> it is echo'ing a <div>, not just .text
        $("#searchResults").html(response).show();
        console.log('name found')

        $('#addOwnItem').on('click', function(){
            console.log('clicked on add item modal')
            $('#addItemModal').modal('show');
        })

    }).fail(function(){
        console.log('fail')
    })
    return false
    }
});


$(document).ready(function(){
    $('.editItemBtn').on('click', function(){
        $('#editItemModal').modal('show');    
            
        var passedId = $(this).data('id');
        $('#rowId').val(passedId);

        var passedName = $(this).data('name');
        $('input:text').val(passedName);
        
        var passedNote = $(this).data('note');
        $('textarea').val(passedNote);
        
        var passedDate = $(this).data('expires');
        console.log(passedDate)
        // only use 10 numbers in timestamp (which is the date)
        $('#editExpiryDay').val(passedDate.substring(0,10));
     
    })
});



$('#expiredItemsContainer').hide();
$('#overviewBtn').on('click', function(){
    $('#expiredItemsContainer').toggle();
})



