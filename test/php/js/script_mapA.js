// Canvas Position Variables
var cposX = 0,
    cposY = 0;
// Mouse Down Position Variables
var posX = 0,
    posY = 0;
// Mouse Moving Position Variables
var nposX = 0,
    nposY = 0;
// Coordinate Position in Percentage Variables
var px1_perc = 0,
    py1_perc = 0,
    px2_perc = 0,
    py2_perc = 0;
// Canvas Variable
var ctx;
// Variable for checking if the mouse has started to draw or not
var isDraw = false;

// Function that creates the Area tag and appends to the Map Tag
function mapped_area(stored) {
    if (Object.keys(stored).length > 0) {
        // Empty Map Tag First
        $('#fp-map').html('')

        // Looping Data
        Object.keys(stored).map(k => {
            // Loop Current Data
            var data = stored[k]
                // Creating New Area Tag
            var area = $("<area shape='rect'>")
            area.attr('href', "javascript:void(0)")
                // Coordinate Percentage
            var perc = data.coord_perc
            perc = perc.replace(" ", '')
            perc = perc.split(",")

            // Configuring Area Position, Height, and Width
            var x = $('#fp-img').width() * perc[0];
            var y = $('#fp-img').height() * perc[1];
            var width = Math.abs(($('#fp-img').width() * Math.abs(perc[2])) - x);
            var height = Math.abs(($('#fp-img').height() * Math.abs(perc[3])) - y);
            if (($('#fp-img').width() * perc[2]) - x < 0)
                x = x - width
            if (($('#fp-img').height() * perc[3]) - y < 0)
                y = y - height
            area.attr('coords', x + ", " + y + ", " + width + ", " + height)
            area.addClass('fw-bolder text-muted')
            area.css({
                'height': height + 'px',
                'width': width + 'px',
                'top': y + 'px',
                'left': x + 'px',
            })

            $('#fp-map').append(area)

            // Action to make if the Area Tag has been clicked
            area.click(function() {
                $('#view_modal').find('#edit-area,#delete-area').attr('data-id', data.id)
                data.description = data.description.replace(/\n/gi, "<br>")
                $('#view_modal').find('.modal-body').html(data.description)
                $('#view_modal').modal('show')
            })
        })
    }
}

// Function to load mapped areas from the server
function loadMappedAreas() {
    $.ajax({
        url: "../loadmapped_areas.php",
//path/to/your/load-server-side-script.php
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                // Create mapped areas on the image
                mapped_area(response.areas);
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + status + " - " + error);
        }
    });
}

$(function() {
    cposX = $('#fp-canvas')[0].getBoundingClientRect().x
    cposY = $('#fp-canvas')[0].getBoundingClientRect().y
        ctx = $('#fp-canvas')[0].getContext('2d');

    // Load mapped areas from the server
    loadMappedAreas();

    // Re-initialize Map Area Creation when the window has been resized
    $(window).on('resize', function() {
        mapped_area();
    })

    // Event Listener when the mouse is clicked on the canvas area
    $('.fp-canvas').on('mousedown', function(e) {
        px1_perc = (e.clientX - cposX) / $('#fp-canvas').width()
        py1_perc = (e.clientY - cposY) / $('#fp-canvas').height()
        posX = $('#fp-canvas')[0].width * ((e.clientX - cposX) / $('#fp-canvas').width());
        posY = $('#fp-canvas')[0].height * ((e.clientY - cposY) / $('#fp-canvas').height());
        isDraw = true
    })

    // Event Listener when the mouse is moving on the canvas area. For drawing the rectangular Area
    $('.fp-canvas').on('mousemove', function(e) {
            if (isDraw == false)
                return false;
            nposX = $('#fp-canvas')[0].width * ((e.clientX - cposX) / $('#fp-canvas').width());
            nposY = $('#fp-canvas')[0].height * ((e.clientY - cposY) / $('#fp-canvas').height());
            var height = nposY - posY;
            var width = nposX - posX;
            ctx.clearRect(0, 0, $('.fp-canvas')[0].width, $('.fp-canvas')[0].height);
            ctx.beginPath();
            ctx.lineWidth = ".3";
            ctx.strokeStyle = "pink";
            ctx.rect(posX, posY, width, height);
            ctx.stroke();
        })
        // Event Listener when the mouse is up on the canvas area. End of Drawing
    $('.fp-canvas').on('mouseup', function(e) {
        px2_perc = (e.clientX - cposX) / $('#fp-canvas').width()
        py2_perc = (e.clientY - cposY) / $('#fp-canvas').height()
        nposX = $('#fp-canvas')[0].width * ((e.clientX - cposX) / $('#fp-canvas').width());
        nposY = $('#fp-canvas')[0].height * ((e.clientY - cposY) / $('#fp-canvas').height());
        var height = nposY - posY;
        var width = nposX - posX;

        ctx.clearRect(0, 0, $('.fp-canvas')[0].width, $('.fp-canvas')[0].height);
        ctx.beginPath();
        ctx.lineWidth = ".3";
        ctx.strokeStyle = "pink";
        ctx.rect(posX, posY, width, height);
        ctx.stroke();
        isDraw = false
    })

    // ... rest of the code
});
// Action when Map Area button is clicked
    $('#map_area').click(function() {
        $(this).hide('slow')
        $('#save,#cancel').show('slow')
        $('#fp-canvas').removeClass('d-none')
        cposX = $('#fp-canvas')[0].getBoundingClientRect().x
        cposY = $('#fp-canvas')[0].getBoundingClientRect().y
    })

    // Action when Map Area cancel is clicked
    $('#cancel').click(function() {
        $('#save,#cancel').hide('slow')
        $('#map_area').show('slow')
        $('#fp-canvas').addClass('d-none')
    })

    // Action when Map Area save is clicked
  $("#save").click(function() {
  // get the mapped areas data
  var areas = getAreas();

  // set the coordinates in the form modal
  var cP = px1_perc + ", " + py1_perc + ", " + px2_perc + ", " + py2_perc
  $('#form_modal').find('input[name="coord_perc"]').val(cP);

  // send the data to the server using AJAX
  $.ajax({
    type: "POST",
    url: "save_areas.php",
    data: { areas: areas },
    success: function(response) {
      alert(response);
      $('#form_modal').modal('hide');
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert("Error: " + textStatus);
    }
  });
});


    // Saving the Mapped Area Details on local Storage
    $('#mapped-form').submit(function(e) {
        e.preventDefault();
        var action = $(this).find('[name="id"]').val() ? 'update' : 'insert';
        var data = {
            id: $(this).find('[name="id"]').val(),
            coord_perc: $(this).find('[name="coord_perc"]').val(),
            description: $(this).find('[name="description"]').val()
        };

        $.ajax({
            type: "POST",
          url: "savearea.php",

            data: { action: action, data: data },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + "\n" + errorThrown);
            }
        });
    });

    // Edit Mapped Area Details
    $('#edit-area').click(function() {
        $('.modal').modal('hide')
        id = $(this).attr('data-id')
        data = stored[id] || {}
        $('#mapped-form').find('[name="id"]').val(data.id)
        $('#mapped-form').find('[name="coord_perc"]').val(data.coord_perc)
        $('#mapped-form').find('[name="description"]').val(data.description)
        $('#form_modal').modal('show')
    })

    // Delete Mapped Area
    $('#delete-area').click(function() {
        $('.modal').modal('hide');
        var id = $(this).attr('data-id');
        var _conf = confirm("Are you sure to delete the selected mapped area?");
        if (_conf === true) {

            var action = 'delete';
            var data = { id: id };

            $.ajax({
                type: "POST",
                url: "savearea.php",

                data: { action: action, data: data },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error: " + textStatus + "\n" + errorThrown);
                }
            });
        }
    });
});
