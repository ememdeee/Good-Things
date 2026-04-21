// @UNUSEDprepros-prepend "bootstrap5/bootstrap.bundle.js";

// @prepros-prepend "plugins/aos.js";
// @UNUSED-MOVEDprepros-prepend "plugins/hc-offcanvas-nav.js";

// @prepros-prepend "theme/general-util.js";
// @UNUSED-MOVEDprepros-prepend "theme/nav.js";
// @prepros-prepend "theme/theme.js";

// wait until DOM loaded
document.addEventListener('DOMContentLoaded', function () {
	
	// // AOS initialization
	var debugRepeat = cd_getParameterByName('debug-repeat');
	AOS.init({
		duration: 900,
		offset: 100,
		once: (debugRepeat == 1) ? false : true
		// anchorPlacement: 'top-top'
	});	

	// set target=_blank for external site
	// maybe no need ??
	document.querySelectorAll('a').forEach(function(anchor) {
		// exclude js url
		if (anchor.href.indexOf('javascript:') > -1) {
			return;
		}
	
		var regex = new RegExp('/' + window.location.host + '/');
		if (!regex.test(anchor.href)) {
			if (!anchor.hasAttribute('target')) {
				anchor.setAttribute("target", "_blank");
			}
			if (!anchor.hasAttribute('rel')) {
				anchor.setAttribute("rel", "noopener noreferrer"); // Add security attributes
			}
		}
	});
	
	
	// set target=_blank for pdf files
	document.querySelectorAll('a[href$=".pdf"]').forEach(function(anchor) {
		anchor.setAttribute('target', '_blank');
	});
	

  // remove hover
  // ideally done in CSS by only applying hover styling in specific condition, 
  // however since we already implement hover on many elements
  // to override all the hover, which is difficult
  // so this is quick and dirty JS solution, taken from https://stackoverflow.com/questions/23885255/how-to-remove-ignore-hover-css-style-on-touch-devices
  function disableHoverOnMobile() {
    // detect mobile by hasTouch... device touch & mouse will be affected
    function hasTouch() {
        return 'ontouchstart' in document.documentElement
              || navigator.maxTouchPoints > 0
              || navigator.msMaxTouchPoints > 0;
    }
    // simple detection by screen size
    function isMobile() {
      if ('screen' in window && window.screen.width <= 768) {
        return true;
      }
    
      var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
      if (connection && connection.type === 'cellular') {
        return true;
      }
    
      return false;
    }

    if (/*hasTouch()*/ isMobile()) { // remove all :hover stylesheets
        try { // prevent exception on browsers not supporting DOM styleSheets properly
            for (var si in document.styleSheets) {
                var styleSheet = document.styleSheets[si];
                if (!styleSheet.rules) continue;

                for (var ri = styleSheet.rules.length - 1; ri >= 0; ri--) {
                    if (!styleSheet.rules[ri].selectorText) continue;

                    if (styleSheet.rules[ri].selectorText.match(':hover')) {
                        styleSheet.deleteRule(ri);
                    }
                }
            }
        } catch (ex) {}
    }
  }
	disableHoverOnMobile();
	

  // table
  // alert('Table');

  // comparison table
  function comparisonTables() {
    const $tableWrappers = document.querySelectorAll('.comparison-table');

    $tableWrappers.forEach($tableWrapper => {
      if (!$tableWrapper.classList.contains('comparison-table--initialized')) {
        const hasRowHeader = $tableWrapper.classList.contains('comparison-table--row-header');

        //  if hasRowHeader, then the change cell markup in first column to th
        if (hasRowHeader) {
          const $rows = $tableWrapper.querySelectorAll('table tbody tr, table tfoot tr');
          $rows.forEach($row => {
            const $firstCell = $row.querySelector('td:first-child');
            if ($firstCell) {
              const $th = document.createElement('th');
              $th.innerHTML = $firstCell.innerHTML;
              $firstCell.parentNode.replaceChild($th, $firstCell);
            }
          });
        }

        // tfoot
        const $tfootContent = $tableWrapper.querySelectorAll('table tfoot th, table tfoot td');
        if ($tfootContent) {
          $tfootContent.forEach($cell => {
            // if there's single a link inside, convert it to <a href="#" class="btn t-tagline"><span class="link-text">[content]</span></a>
            const $link = $cell.querySelector('a');
            if ($link && $cell.children.length === 1) {
              const linkText = $link.textContent;
              $link.innerHTML = '<span class="link-text">' + linkText + '</span>';
              $link.classList.add('btn', 't-tagline');
            }
          });
        }

        // set class comparison-table--initialized
        $tableWrapper.classList.add('comparison-table--initialized');


        const $table = $tableWrapper.querySelector('table');
        // add class table--desktop
        $table.classList.add('table--desktop');

        // create new tables for mobile, as much as columns count, the new mobile tables only contains single column, except if hasRowHeader, then it has two columns
        const columnCount = $table.querySelectorAll('thead tr th').length;

        for (let colIndex = (hasRowHeader ? 1 : 0); colIndex < columnCount; colIndex++) {
          // create new table
          const $mobileTable = document.createElement('table');
          $mobileTable.classList.add('table', 'table--mobile');
          // add attribute data-mobile-column-index
          $mobileTable.setAttribute('data-mobile-column-index', colIndex);

          const $mobileThead = document.createElement('thead');
          const $mobileTbody = document.createElement('tbody');
          $mobileTable.appendChild($mobileThead);
          $mobileTable.appendChild($mobileTbody);
          // create thead
          const $headerRow = document.createElement('tr');
          if (hasRowHeader) {
            const $thHeader = $table.querySelectorAll('thead tr th')[0].cloneNode(true);
            $headerRow.appendChild($thHeader);
          }
          const $th = $table.querySelectorAll('thead tr th')[colIndex].cloneNode(true);
          $headerRow.appendChild($th);
          $mobileThead.appendChild($headerRow);
          
          // create tbody
          const $rows = $table.querySelectorAll('tbody tr');
          $rows.forEach($row => {
            const $mobileRow = document.createElement('tr');
            if (hasRowHeader) {
              const $thHeader = $row.querySelector('th').cloneNode(true);
              $mobileRow.appendChild($thHeader);
            }
            const $td = $row.querySelector('td:nth-child(' + (colIndex + 1) + ')').cloneNode(true);
            $mobileRow.appendChild($td);
            $mobileTbody.appendChild($mobileRow);
          });

          // also tfoot if exists
          const $tfoot = $table.querySelector('tfoot');
          if ($tfoot) {
            const $mobileTfoot = document.createElement('tfoot');
            const $footerRow = document.createElement('tr');
            if (hasRowHeader) {
              const $thFooter = $tfoot.querySelector('tr th').cloneNode(true);
              $footerRow.appendChild($thFooter);
            }
            const $tdFooter = $tfoot.querySelector('tr td:nth-child(' + (colIndex + 1) + ')').cloneNode(true);
            $footerRow.appendChild($tdFooter);
            $mobileTfoot.appendChild($footerRow);
            $mobileTable.appendChild($mobileTfoot);
          }

          // append mobile table to wrapper
          $tableWrapper.appendChild($mobileTable);
        }
      }
    });


  }

  comparisonTables();

});