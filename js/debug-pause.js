(function ($, Drupal) {
  Drupal.behaviors.debugpause = {
    attach: (context, settings) => {
      once('debugpause', 'html', context).forEach( function (element) {
        let $toolbarItem = $('.toolbar-icon.toolbar-icon-debugpause-menu-link');
        let isPausing = false;
        let pausing;
        let counting;

        $('#debugpausebutton').click(()=>{
          if (!isPausing) {
            isPausing = true;
            let seconds = $('#debugpausebutton').attr('pausein');
            let secondsInt = parseInt(seconds/1000);
            $toolbarItem.text(secondsInt);
            $toolbarItem.prop('title', 'Cancels Pause');
            pausing = setTimeout(()=>{
              $toolbarItem.text('Paused');
              debugger;
              clearInterval(counting);
              $toolbarItem.text('Debug Pause');
              $toolbarItem.prop('title', 'Pauses Javascript');
              isPausing = false;
            },seconds);
            counting = setInterval(()=>{
              secondsInt--;
              $toolbarItem.text(secondsInt);
              if (secondsInt === 0) {
                clearInterval(counting);
              }
            }, 1000);
          } else {
            clearTimeout(pausing);
            clearInterval(counting);
            $toolbarItem.text('Cancelled');
            $toolbarItem.prop('title', 'Pauses Javascript');
            setTimeout(()=>{
              $toolbarItem.text('Debug Pause');
              isPausing = false;
            },2000);
          }
        })
      })
    }
  }
} (jQuery, Drupal));
