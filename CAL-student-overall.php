<?php
include './php/database_connect.php';
include './php/admin-signin.php';
include './php/CAL-gapi-retrieve-values.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <!--Calendar JS-->
    <link rel="stylesheet" href="./css/CAL-calendar.css">
  </head>

  <body>
    <div class="container-fluid" id="popup">
      <div class="row popup-card">
        <form method="post">
          <div class="row">
            <div class="col-11 admin-text">
              <p>
                Administrator
              </p>
            </div>
            <div class="col-1 close ">
              <i class='bx bx-x' onclick="hide()"></i>
            </div>
          </div>
          <div class="row">
            <input type="text" name="user_username" placeholder="Username" maxlength="20" required/>
          </div>
          <div class="row">
            <input type="password" name="user_password" placeholder="Password" maxlength="128" required/>
          </div>
          <div class="row justify-content-center">
            <button input type="submit" name="sign-in-button" class="sign-in-button">Sign In</button>
          </div>
        </form>
      </div>
    </div>
     <!--SIDEBAR-->
     <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'calendar';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section mobile-size">
      <div id="calendar-container">
        <div class="d-flex justify-content-between">
          <h2 id="current-month"></h2>
          <!-- Filter Dropdown -->
          <div class="dropdown p-2">
            <button class="btn btn-light btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              Filters
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li>
                <div class="accordion" id="mobileOrganizationAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-bs-parent="#mobileOrganizationAccordion">
                        Organization
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                      <div class="accordion-body" id="mobileOrgCheckboxes">
                        <!-- Organization checkboxes will be dynamically generated here -->
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="accordion" id="mobileEventTypeAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" data-bs-parent="#mobileEventTypeAccordion">
                        Event Type
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                      <div class="accordion-body" id="mobileEventTypeCheckboxes">
                        <!-- Event Type checkboxes will be dynamically generated here -->
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        </div>
        <div id="calendar-header">
          <div class="calendar-navigation">
            <button type="button" id="mobile-prev-month" class="btn btn-secondary"><</button>
            <button type="button" id="mobile-next-month" class="btn btn-secondary">></button>
          </div>
        </div>
        <table id="mobile-calendar" class="table">
          <thead>
            <tr>
              <th class="text-center" scope="col">SU</th>
              <th class="text-center" scope="col">M</th>
              <th class="text-center" scope="col">TU</th>
              <th class="text-center" scope="col">W</th>
              <th class="text-center" scope="col">TH</th>
              <th class="text-center" scope="col">F</th>
              <th class="text-center" scope="col">SA</th>
            </tr>
          </thead>
          <tbody id="mobile-calendar-days">
          </tbody>
        </table>
        <div class="container-fluid">
          <div class="container-fluid" id="current-events">
            <h2 class="text-center" id="currentEventsTitle"></h2>
            <br>
            <div class="scrollable-container" id="showSelectedEvents">
            </div>
            <div class="div" id="noShowSelectedEvents">
              <div class="element">
                <div class="row">
                  <div class="element-group">
                    <div class="element-content">
                      <div class="vstack gap-3">
                        <h2 class="p-2 no-events-shown-text">Oops!</h2>
                        <h4 class="p-2 no-events-shown-text">There are no events</h4>
                        <img class="p-2 img-fluid" id="noEventsImg" src="./pictures/no-upcoming-events.svg" alt="No Events">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="container-fluid" id="upcoming-events">
            <h2 class="text-center" id="currentEventsTitle">Upcoming Events</h2>
            <br>
            <div class="scrollable-container" id="showUpcomingEvents">
            </div>
            <div class="div" id="noShowUpcomingEvents">
              <div class="element">
                <div class="row">
                  <div class="element-group">
                    <div class="element-content">
                      <div class="vstack gap-3">
                        <h2 class="p-2 no-events-shown-text">Oops!</h2>
                        <h4 class="p-2 no-events-shown-text">There are no upcoming events</h4>
                        <img class="p-2 img-fluid" id="noEventsImg" src="./pictures/no-upcoming-events.svg" alt="No Events">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
      <div class="floating">
        <div class="floating-main">
          <i class='bx bx-menu'></i>          
        </div>
        <div class="float-opt opt-text show-modal">
          <i class='bx bx-calendar'></i>
        </div>
      </div> 
      <div class="bottom-sheet">
        <div class="sheet-overlay"></div>
        <div class="content">
          <div class="header">
            <div class="drag-icon"><span></span></div>
          </div>
          <div class="body text-center">
            <h2>Search Date</h2>
            <br>
            <div class="container text-center">
              <div class="row justify-content-md-center">
                <input type="date" id="date_mobile_search" name="date_mobile_search">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Calendar Computer-->
    <section class="home-section computer-size">
      <div class="header">Calendar</div>
        <div class="d-flex">
          <h1 class="p-2" id="calendar-title"></h1>
          <!-- Mini Calendar -->
          <div class="flex-grow-1 p-2">
            <i id="miniCalendarToggle" class="bx bxs-down-arrow"></i>
          </div>
          <div class="div" id="miniCalendarContainer" style="display: none;">
            <div class="element" id="calendarElement">
              <div class="row">
                <div id="miniCalendarMain">
                  <div class="d-flex justify-content-between">
                    <h5 id="miniCalendarHeader"></h5>
                    <div id="miniButtonContainer">
                      <i id="miniPreviousButton" class='bx bxs-chevron-left'></i>
                      <i id="miniNextButton" class='bx bxs-chevron-right'></i>
                    </div>
                    <div id="miniButtonYearsContainer">
                      <i id="miniPreviousYearsButton" class='bx bxs-chevron-left'></i>
                      <i id="miniNextYearsButton" class='bx bxs-chevron-right'></i>
                    </div>
                  </div>
                  <br>
                  <table id="miniCalendar">
                    <thead id="miniCalendarThead">
                      <tr>
                        <th scope="col">SU</th>
                        <th scope="col">M</th>
                        <th scope="col">TU</th>
                        <th scope="col">W</th>
                        <th scope="col">TH</th>
                        <th scope="col">F</th>
                        <th scope="col">SA</th>
                      </tr>
                    </thead>
                    <tbody id="miniCalendarTable">
                    </tbody>
                    <tbody id="miniCalendarYearsTable">
                    </tbody>
                  </table>
                  <br>
                </div>
              </div>
              <div class="div">
                <button id="closeButton" class="outline-button p-3">Close</button>
                <button id="todayButton" class="primary-button p-3">Today</button>
              </div>
            </div>
          </div>
          <!-- Filter Dropdown -->
          <div class="dropdown p-2">
            <button class="btn btn-light btn-lg dropdown-toggle" style="width: 190px;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              Filters
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li>
                <div class="accordion" id="organizationAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-bs-parent="#organizationAccordion">
                      Organization
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                      <div class="accordion-body" id="orgCheckboxes">
                        <!-- Organization checkboxes will be dynamically generated here -->
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="accordion" id="eventTypeAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" data-bs-parent="#eventTypeAccordion">
                        Event Type
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                      <div class="accordion-body" id="eventTypeCheckboxes">
                        <!-- Event Type checkboxes will be dynamically generated here -->
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        </div>
        <!-- Calendar -->
        <div class="container-fluid">
          <div class="row">
            <div class="container-fluid">
              <div class="calendar-row-styled shadow-lg p-3 mb-5">
                <div class="calendar-navigation">
                  <button type="button" id="prev-month" class="btn btn-primary rounded-pill"><h2><</h2></button>
                  <button type="button" id="next-month" class="btn btn-primary rounded-pill"><h2>></h2></button>
                </div>
                <table id="calendar" class="table">
                  <thead class="calendar-weeks" id="table-headers">
                    <tr class="border border-0">
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">SUNDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">MONDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">TUESDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">WEDNESDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">THURSDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">FRIDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">SATURDAY</th>
                    </tr>
                  </thead>
                  <tbody class="calendar-days border border-5">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/HOM-popup.js"></script>
    <script type="text/javascript">
      $('.menu_btn').click(function (e) {
        e.preventDefault();
        var $this = $(this).parent().find('.sub_list');
        $('.sub_list').not($this).slideUp(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.removeClass('bx-chevron-down').addClass('bx-chevron-right');
        });

        $this.slideToggle(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.toggleClass('bx-chevron-right bx-chevron-down')
        });
      });
    </script>
    <!--Calendar JS-->
    <script defer src="./js/CAL-student-calendar.js"></script>
    <!-- Google API Calendar -->
    <script type="text/javascript">
      const CLIENT_ID = '<?php echo $CLIENT_ID; ?>';
      const API_KEY = '<?php echo $API_KEY; ?>';
      const DISCOVERY_DOC = '<?php echo $DISCOVERY_DOC; ?>';
      const SCOPES = '<?php echo $SCOPES; ?>';

      let tokenClient;
      let gapiInited = false;
      let gisInited = false;

      function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
      }

      async function initializeGapiClient() {
        await gapi.client.init({
          apiKey: API_KEY,
          discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
      }

      function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
          client_id: CLIENT_ID,
          scope: SCOPES,
          callback: '',
        });
        gisInited = true;
      }

      async function handleAuthClick(eventDate, categoryName, eventDescription, eventTime) {
        tokenClient.callback = async (resp) => {
          if (resp.error !== undefined) {
            throw (resp);
          }
          await listUpcomingEvents(eventDate, categoryName, eventDescription, eventTime);
        };

        if (gapi.client.getToken() === null) {
          tokenClient.requestAccessToken({prompt: 'consent'});
        } else {
          tokenClient.requestAccessToken({prompt: ''});
          await handleSignoutClick();
        }
      }

      async function handleSignoutClick() {
        const token = gapi.client.getToken();
        if (token !== null) {
          google.accounts.oauth2.revoke(token.access_token);
          gapi.client.setToken('');
        }
      }

      async function listUpcomingEvents(eventDate, categoryName, eventDescription, eventTime) {

        let timeString = eventTime;
        let date = new Date();
        date.setHours(0); // Set the date to a fixed value to only represent the time
        date.setMinutes(0);
        date.setSeconds(0);

        let timeParts = timeString.split(':');
        let hours = parseInt(timeParts[0], 10);
        let minutes = parseInt(timeParts[1].split(' ')[0], 10);

        if (timeString.indexOf('PM') !== -1 && hours !== 12) {
          hours += 12;
        }

        date.setHours(hours);
        date.setMinutes(minutes);

        let formattedTime = date.toLocaleTimeString('en-US', { hour12: false });

        const encodedEventDesc = he.encode(eventDescription);
        const encodedCategoryName = he.encode(categoryName);

        const event = {
          'summary': encodedCategoryName,
          'description': encodedEventDesc,
          'start': {
            'dateTime': eventDate + 'T' + formattedTime,
            'timeZone': 'Asia/Singapore'
          },
          'end': {
            'dateTime': eventDate + 'T' + formattedTime,
            'timeZone': 'Asia/Singapore'
          },
          'reminders': {
            'useDefault': false,
            'overrides': [
              {'method': 'email', 'minutes': 24 * 60},
              {'method': 'popup', 'minutes': 10}
            ]
          }
        };

        const request = gapi.client.calendar.events.insert({
          'calendarId': 'primary',
          'resource': event
        });

        function closeModal() {
          $('.modal').modal('hide');
          // Remove the existing modal backdrop if it exists
          var modalBackdrop = document.querySelector('.modal-backdrop');
          if (modalBackdrop) {
            modalBackdrop.remove();
          }
          var modalContent = `
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body text-center">
                  <br>
                  <i class='bx bx-calendar-check bx-lg' id='calendar-check-icon'></i>
                  <br>
                  <br>
                  <br>
                  <h1 class="modal-title fs-4" id="exampleModalLabel">Successfully Added</h1>
                  <br>
                  <br>
                  <h1 class="modal-title fs-5">The event has been successfully added to your Google Calendar</h1>
                  <br>
                  <br>
                </div>
              </div>
            </div>
          </div>
          `;
          
          // Append the modal to the document body
          document.body.insertAdjacentHTML('beforeend', modalContent);
          
          // Show the modal
          $('#exampleModal').modal('show');
          
          // Close the modal after 3 seconds
          setTimeout(function() {
            $('#exampleModal').modal('hide');
            // Remove the existing modal backdrop if it exists
            var modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
              modalBackdrop.remove();
            }
          }, 3000);
        }

        request.execute(function(event) {
          closeModal();
        });
      }
    </script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
    <!--HE JS-->
    <script src="https://cdn.jsdelivr.net/npm/he/he.js"></script>
  </body>
</html>