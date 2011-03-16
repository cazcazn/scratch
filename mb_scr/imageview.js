$(document).ready(function() {

  // On hovering over someone's name, display the face box and write their name underneath
  function tag_name_mousein() {
    $(this).addClass("tag_name_displayed");
    $("#facebox"+$(".tag_name").index(this)).addClass("facebox_displayed");
  }

  // On taking the mouse off, undo the changes
  function tag_name_mouseout() {
    $(this).removeClass("tag_name_displayed");
    $("#facebox"+$(".tag_name").index(this)).removeClass("facebox_displayed").empty();
  }

  // On hovering over someone's face, make their name bold and show the name where the mouse is
  function tag_box_mousein() {

    var newSpan = document.createElement("span");
    newSpan.className = "face_name_displayed";
    newSpan.innerHTML = $("#tag_name"+$(".facebox").index(this)).text();
    $(this).append(newSpan);

  }

  // When taking the mouse off the face, undo the changes
  function tag_box_mouseout() {
    $(this).empty();
  }

  // Bind hover event handler to all tag boxes
  $(".facebox").hover(tag_box_mousein, tag_box_mouseout);

  // Bind hover event handler to all tag spans
  $(".tag_name").hover(tag_name_mousein, tag_name_mouseout);

  // Mouse coords have to be global for AJAX
  var x;
  var y;

  // Bind the image clicked function to the image
  $('#imgview').unbind("click").click(image_clicked);
  $(document).unbind("click").bind("click", body_clicked);

  function body_clicked(e) {
    if(e.target.nodeName != "IMG") {
      if((e.target.className).match(/facebox|tag_name/) == null) {
        $('#tag_textbox').val("");
        $('#tag_box').hide();
      }
      else {
        image_clicked(e);
      }
    }
  }

  function image_clicked(e) {

    // Determine the offset where the user has clicked
    x = e.pageX - $('#imgview').offset().left;
    y = e.pageY - $('#imgview').offset().top;


    // Calculate the offset of the container
    var contX = (x - $('#tag_box').outerWidth() / 2) + "px";
    var contY = (y - $('#tag_facebox').outerWidth() / 2) + "px";

    // Display the tag box where the mouse is centered
    $('#tag_box').css("left", contX).css("top", contY);
    $('#tag_box').show();
    $('#tag_textbox').focus();

  }

  // Click event for input box
  $('#tag_textbox').click(function(e) {
    e.stopPropagation();
  });

  // Event handler for 'enter' - only called if the textbox value is greater than 6
  $('#tag_textbox').keypress(function(e) {
    if(e.which == 13 && $(this).val().length > 4) {
      // Perform AJAX
      $.ajax({
        type: "POST",
        url: 'ajax/tagajax.php',
        dataType: 'html',
        data: {
          'filename': $('#imgview').attr("src"),
          'tagname': $(this).val(),
          'x': x,
          'y': y},
        success: function (ret) {

          // Calculate the offset for the face rectangle
          rO = 22;

          // New index of span and box:
          var newIndex = $(".tag_name").length;
          var indexToAppendTo = -1;

          // Determine where in the names list it should appear
          $('.facebox').each(function(index, value) {
            if(x < $(value).position().left) {
              indexToAppendTo = index - 1;
              return false;
            }
            if(x == $(value).position().left) {
              if(y < $(value).position().top) {
                indexToAppendTo = index - 1;
                return false;
              }
            }
            indexToAppendTo = index;
          });

          // Form the new span tag and add hover event
          var spanString = $('<span class="tag_name" id="tag_name'+newIndex+'">' + $('#tag_textbox').val() + '</span>').hover(tag_name_mousein, tag_name_mouseout);

          // If it's the first one
          if(indexToAppendTo == -1) {
            spanString.prependTo($('#tag_names'));
          } else {
            spanString.insertAfter($('#tag_name'+indexToAppendTo));
          }

          var divString = $('<div class="facebox" id="facebox'+newIndex+'" style="top:'+(y-rO)+'px; left:'+(x-rO)+'px"></div>').hover(tag_box_mousein, tag_box_mouseout);

          // Form the new div, add hover event and append it to the frame
          $('#content').append(divString);

          // Hide the tagging stuff
          $('#tag_textbox').val("");
          $('#tag_box').hide();
        },
        error: function(v1, v2, v3) {console.log(v1, v2, v3);}
      });
    }
  });
});
