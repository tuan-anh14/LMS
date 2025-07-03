/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*******************************************************!*\
  !*** ./public/admin_assets/custom/js/shared/theme.js ***!
  \*******************************************************/
$(function () {
  var vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');
  $.app = $.app || {};
  var $body = $('body');
  var $window = $(window);
  var menuWrapper_el = $('div[data-menu="menu-wrapper"]').html();
  var menuWrapperClasses = $('div[data-menu="menu-wrapper"]').attr('class');

  // Main menu
  $.app.menu = {
    expanded: null,
    collapsed: null,
    hidden: null,
    container: null,
    horizontalMenu: false,
    is_touch_device: function is_touch_device() {
      var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
      var mq = function mq(query) {
        return window.matchMedia(query).matches;
      };
      if ('ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch) {
        return true;
      }
      // include the 'heartz' as a way to have a non matching MQ to help terminate the join
      // https://git.io/vznFH
      var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
      return mq(query);
    },
    manualScroller: {
      obj: null,
      init: function init() {
        var scroll_theme = $('.main-menu').hasClass('menu-dark') ? 'light' : 'dark';
        if (!$.app.menu.is_touch_device()) {
          this.obj = new PerfectScrollbar('.main-menu-content', {
            suppressScrollX: true,
            wheelPropagation: false
          });
        } else {
          $('.main-menu').addClass('menu-native-scroll');
        }
      },
      update: function update() {
        // if (this.obj) {
        // Scroll to currently active menu on page load if data-scroll-to-active is true
        if ($('.main-menu').data('scroll-to-active') === true) {
          var activeEl, menu, activeElHeight;
          activeEl = document.querySelector('.main-menu-content li.active');
          menu = document.querySelector('.main-menu-content');
          if ($('body').hasClass('menu-collapsed')) {
            if ($('.main-menu-content li.sidebar-group-active').length) {
              activeEl = document.querySelector('.main-menu-content li.sidebar-group-active');
            }
          }
          if (activeEl) {
            activeElHeight = activeEl.getBoundingClientRect().top + menu.scrollTop;
          }

          // If active element's top position is less than 2/3 (66%) of menu height than do not scroll
          if (activeElHeight > parseInt(menu.clientHeight * 2 / 3)) {
            var start = menu.scrollTop,
              change = activeElHeight - start - parseInt(menu.clientHeight / 2);
          }
          setTimeout(function () {
            $.app.menu.container.stop().animate({
              scrollTop: change
            }, 300);
            $('.main-menu').data('scroll-to-active', 'false');
          }, 300);
        }
        // this.obj.update();
        // }
      },
      enable: function enable() {
        if (!$('.main-menu-content').hasClass('ps')) {
          this.init();
        }
      },
      disable: function disable() {
        if (this.obj) {
          this.obj.destroy();
        }
      },
      updateHeight: function updateHeight() {
        if (($('body').data('menu') == 'vertical-menu' || $('body').data('menu') == 'vertical-menu-modern' || $('body').data('menu') == 'vertical-overlay-menu') && $('.main-menu').hasClass('menu-fixed')) {
          $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height() - $('.main-menu-header').outerHeight() - $('.main-menu-footer').outerHeight());
          this.update();
        }
      }
    },
    init: function init(compactMenu) {
      if ($('.main-menu-content').length > 0) {
        this.container = $('.main-menu-content');
        var menuObj = this;
        this.change(compactMenu);
      }
    },
    change: function change(compactMenu) {
      var currentBreakpoint = Unison.fetch.now(); // Current Breakpoint

      this.reset();
      var menuType = $('body').data('menu');
      if (currentBreakpoint) {
        switch (currentBreakpoint.name) {
          case 'xl':
            if (menuType === 'vertical-overlay-menu') {
              this.hide();
            } else {
              if (compactMenu === true) this.collapse(compactMenu);else this.expand();
            }
            break;
          case 'lg':
            if (menuType === 'vertical-overlay-menu' || menuType === 'vertical-menu-modern' || menuType === 'horizontal-menu') {
              this.hide();
            } else {
              this.collapse();
            }
            break;
          case 'md':
          case 'sm':
            this.hide();
            break;
          case 'xs':
            this.hide();
            break;
        }
      }

      // On the small and extra small screen make them overlay menu
      if (menuType === 'vertical-menu' || menuType === 'vertical-menu-modern') {
        this.toOverlayMenu(currentBreakpoint.name, menuType);
      }
      if ($('body').is('.horizontal-layout') && !$('body').hasClass('.horizontal-menu-demo')) {
        this.changeMenu(currentBreakpoint.name);
        $('.menu-toggle').removeClass('is-active');
      }

      // Dropdown submenu on large screen on hover For Large screen only
      // ---------------------------------------------------------------
      if (currentBreakpoint.name == 'xl') {
        $(document) // Use selector $('body[data-open="hover"] .header-navbar .dropdown') for menu and navbar DD open on hover
        .on('mouseenter', 'body[data-open="hover"] .main-menu-content .dropdown', function () {
          if (!$(this).hasClass('show')) {
            $(this).addClass('show');
          } else {
            $(this).removeClass('show');
          }
        }).on('mouseleave', 'body[data-open="hover"] .main-menu-content .dropdown', function (event) {
          $(this).removeClass('show');
        });
        /* ? Uncomment to enable all DD open on hover
         $('body[data-open="hover"] .dropdown a').on('click', function (e) {
         if (menuType == 'horizontal-menu') {
         var $this = $(this);
         if ($this.hasClass('dropdown-toggle')) {
         return false;
         }
         }
         });
         */
      }

      // Added data attribute brand-center for navbar-brand-center

      if (currentBreakpoint.name == 'sm' || currentBreakpoint.name == 'xs') {
        $('.header-navbar[data-nav=brand-center]').removeClass('navbar-brand-center');
      } else {
        $('.header-navbar[data-nav=brand-center]').addClass('navbar-brand-center');
      }
      // On screen width change, current active menu in horizontal
      if (currentBreakpoint.name == 'xl' && menuType == 'horizontal-menu') {
        $('.main-menu-content').find('li.active').parents('li').addClass('sidebar-group-active active');
      }
      if (currentBreakpoint.name !== 'xl' && menuType == 'horizontal-menu') {
        $('#navbar-type').toggleClass('d-none d-xl-block');
      }

      // Dropdown submenu on small screen on click
      // --------------------------------------------------
      $(document).on('click', 'ul.dropdown-menu [data-toggle=dropdown]', function (event) {
        if ($(this).siblings('ul.dropdown-menu').length > 0) {
          event.preventDefault();
        }
        event.stopPropagation();
        $(this).parent().siblings().removeClass('show');
        $(this).parent().toggleClass('show');
      });

      // Horizontal layout submenu drawer scrollbar
      if (menuType == 'horizontal-menu') {
        $(document).on('mouseenter', 'li.dropdown-submenu', function () {
          if (!$(this).parent('.dropdown').hasClass('show')) {
            $(this).removeClass('openLeft');
          }
          var dd = $(this).find('.dropdown-menu');
          if (dd) {
            var pageHeight = $(window).height(),
              // ddTop = dd.offset().top,
              ddTop = $(this).position().top,
              ddLeft = dd.offset().left,
              ddWidth = dd.width(),
              ddHeight = dd.height();
            if (pageHeight - ddTop - ddHeight - 28 < 1) {
              var maxHeight = pageHeight - ddTop - 170;
              $(this).find('.dropdown-menu').css({
                'max-height': maxHeight + 'px',
                'overflow-y': 'auto',
                'overflow-x': 'hidden'
              });
              var menu_content = new PerfectScrollbar('li.dropdown-submenu.show .dropdown-menu', {
                wheelPropagation: false
              });
            }
            // Add class to horizontal sub menu if screen width is small
            if (ddLeft + ddWidth - (window.innerWidth - 16) >= 0) {
              $(this).addClass('openLeft');
            }
          }
        });
        $('.theme-layouts').find('.semi-dark').hide();
      }

      // Horizontal Fixed Nav Sticky hight issue on small screens
      // if (menuType == 'horizontal-menu') {
      //   if (currentBreakpoint.name == 'sm' || currentBreakpoint.name == 'xs') {
      //     if ($(".menu-fixed").length) {
      //       $(".menu-fixed").unstick();
      //     }
      //   }
      //   else {
      //     if ($(".navbar-fixed").length) {
      //       $(".navbar-fixed").sticky();
      //     }
      //   }
      // }
    },
    transit: function transit(callback1, callback2) {
      var menuObj = this;
      $('body').addClass('changing-menu');
      callback1.call(menuObj);
      if ($('body').hasClass('vertical-layout')) {
        if ($('body').hasClass('menu-open') || $('body').hasClass('menu-expanded')) {
          $('.menu-toggle').addClass('is-active');

          // Show menu header search when menu is normally visible
          if ($('body').data('menu') === 'vertical-menu') {
            if ($('.main-menu-header')) {
              $('.main-menu-header').show();
            }
          }
        } else {
          $('.menu-toggle').removeClass('is-active');

          // Hide menu header search when only menu icons are visible
          if ($('body').data('menu') === 'vertical-menu') {
            if ($('.main-menu-header')) {
              $('.main-menu-header').hide();
            }
          }
        }
      }
      setTimeout(function () {
        callback2.call(menuObj);
        $('body').removeClass('changing-menu');
        menuObj.update();
      }, 500);
    },
    open: function open() {
      this.transit(function () {
        $('body').removeClass('menu-hide menu-collapsed').addClass('menu-open');
        this.hidden = false;
        this.expanded = true;
        if ($('body').hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').addClass('show');
          // $('.sidenav-overlay').removeClass('d-none').addClass('d-block');
          // $('body').css('overflow', 'hidden');
        }
      }, function () {
        if (!$('.main-menu').hasClass('menu-native-scroll') && $('.main-menu').hasClass('menu-fixed')) {
          this.manualScroller.enable();
          $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height() - $('.main-menu-header').outerHeight() - $('.main-menu-footer').outerHeight());
          // this.manualScroller.update();
        }
        if (!$('body').hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').removeClass('show');
          // $('.sidenav-overlay').removeClass('d-block d-none');
          // $('body').css('overflow', 'auto');
        }
      });
    },
    hide: function hide() {
      this.transit(function () {
        $('body').removeClass('menu-open menu-expanded').addClass('menu-hide');
        this.hidden = true;
        this.expanded = false;
        if ($('body').hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').removeClass('show');
          // $('.sidenav-overlay').removeClass('d-block').addClass('d-none');
          // $('body').css('overflow', 'auto');
        }
      }, function () {
        if (!$('.main-menu').hasClass('menu-native-scroll') && $('.main-menu').hasClass('menu-fixed')) {
          this.manualScroller.enable();
        }
        if (!$('body').hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').removeClass('show');
          // $('.sidenav-overlay').removeClass('d-block d-none');
          // $('body').css('overflow', 'auto');
        }
      });
    },
    expand: function expand() {
      if (this.expanded === false) {
        if ($('body').data('menu') == 'vertical-menu-modern') {
          $('.modern-nav-toggle').find('.collapse-toggle-icon').replaceWith(feather.icons['disc'].toSvg({
            "class": 'd-none d-xl-block collapse-toggle-icon primary font-medium-4'
          }));
        }
        this.transit(function () {
          $('body').removeClass('menu-collapsed').addClass('menu-expanded');
          this.collapsed = false;
          this.expanded = true;
          $('.sidenav-overlay').removeClass('show');

          // $('.sidenav-overlay').removeClass('d-block d-none');
        }, function () {
          if ($('.main-menu').hasClass('menu-native-scroll') || $('body').data('menu') == 'horizontal-menu') {
            this.manualScroller.disable();
          } else {
            if ($('.main-menu').hasClass('menu-fixed')) this.manualScroller.enable();
          }
          if (($('body').data('menu') == 'vertical-menu' || $('body').data('menu') == 'vertical-menu-modern') && $('.main-menu').hasClass('menu-fixed')) {
            $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height() - $('.main-menu-header').outerHeight() - $('.main-menu-footer').outerHeight());
            // this.manualScroller.update();
          }
        });
      }
    },
    collapse: function collapse() {
      if (this.collapsed === false) {
        if ($('body').data('menu') == 'vertical-menu-modern') {
          $('.modern-nav-toggle').find('.collapse-toggle-icon').replaceWith(feather.icons['circle'].toSvg({
            "class": 'd-none d-xl-block collapse-toggle-icon primary font-medium-4'
          }));
        }
        this.transit(function () {
          $('body').removeClass('menu-expanded').addClass('menu-collapsed');
          this.collapsed = true;
          this.expanded = false;
          $('.content-overlay').removeClass('d-block d-none');
        }, function () {
          if ($('body').data('menu') == 'horizontal-menu' && $('body').hasClass('vertical-overlay-menu')) {
            if ($('.main-menu').hasClass('menu-fixed')) this.manualScroller.enable();
          }
          if (($('body').data('menu') == 'vertical-menu' || $('body').data('menu') == 'vertical-menu-modern') && $('.main-menu').hasClass('menu-fixed')) {
            $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height());
            // this.manualScroller.update();
          }
          if ($('body').data('menu') == 'vertical-menu-modern') {
            if ($('.main-menu').hasClass('menu-fixed')) this.manualScroller.enable();
          }
        });
      }
    },
    toOverlayMenu: function toOverlayMenu(screen, menuType) {
      var menu = $('body').data('menu');
      if (menuType == 'vertical-menu-modern') {
        if (screen == 'lg' || screen == 'md' || screen == 'sm' || screen == 'xs') {
          if ($('body').hasClass(menu)) {
            $('body').removeClass(menu).addClass('vertical-overlay-menu');
          }
        } else {
          if ($('body').hasClass('vertical-overlay-menu')) {
            $('body').removeClass('vertical-overlay-menu').addClass(menu);
          }
        }
      } else {
        if (screen == 'sm' || screen == 'xs') {
          if ($('body').hasClass(menu)) {
            $('body').removeClass(menu).addClass('vertical-overlay-menu');
          }
        } else {
          if ($('body').hasClass('vertical-overlay-menu')) {
            $('body').removeClass('vertical-overlay-menu').addClass(menu);
          }
        }
      }
    },
    changeMenu: function changeMenu(screen) {
      // Replace menu html
      $('div[data-menu="menu-wrapper"]').html('');
      $('div[data-menu="menu-wrapper"]').html(menuWrapper_el);
      var menuWrapper = $('div[data-menu="menu-wrapper"]'),
        menuContainer = $('div[data-menu="menu-container"]'),
        menuNavigation = $('ul[data-menu="menu-navigation"]'),
        /*megaMenu           = $('li[data-menu="megamenu"]'),
         megaMenuCol        = $('li[data-mega-col]'),*/
        dropdownMenu = $('li[data-menu="dropdown"]'),
        dropdownSubMenu = $('li[data-menu="dropdown-submenu"]');
      if (screen === 'xl') {
        // Change body classes
        $('body').removeClass('vertical-layout vertical-overlay-menu fixed-navbar').addClass($('body').data('menu'));

        // Remove navbar-fix-top class on large screens
        $('nav.header-navbar').removeClass('fixed-top');

        // Change menu wrapper, menu container, menu navigation classes
        menuWrapper.removeClass().addClass(menuWrapperClasses);
        $(document).on('click', 'a.dropdown-item.nav-has-children', function () {
          event.preventDefault();
          event.stopPropagation();
        });
        $(document).on('click', 'a.dropdown-item.nav-has-parent', function () {
          event.preventDefault();
          event.stopPropagation();
        });
      } else {
        // Change body classes
        $('body').removeClass($('body').data('menu')).addClass('vertical-layout vertical-overlay-menu fixed-navbar');

        // Add navbar-fix-top class on small screens
        $('nav.header-navbar').addClass('fixed-top');

        // Change menu wrapper, menu container, menu navigation classes
        menuWrapper.removeClass().addClass('main-menu menu-light menu-fixed menu-shadow');
        // menuContainer.removeClass().addClass('main-menu-content');
        menuNavigation.removeClass().addClass('navigation navigation-main');

        // If Dropdown Menu
        dropdownMenu.removeClass('dropdown').addClass('has-sub');
        dropdownMenu.find('a').removeClass('dropdown-toggle nav-link');
        dropdownMenu.children('ul').find('a').removeClass('dropdown-item');
        dropdownMenu.find('ul').removeClass('dropdown-menu');
        dropdownSubMenu.removeClass().addClass('has-sub');
        $.app.nav.init();

        // Dropdown submenu on small screen on click
        // --------------------------------------------------
        $(document).on('click', 'ul.dropdown-menu [data-toggle=dropdown]', function (event) {
          event.preventDefault();
          event.stopPropagation();
          $(this).parent().siblings().removeClass('open');
          $(this).parent().toggleClass('open');
        });
        $('.main-menu-content').find('li.active').parents('li').addClass('sidebar-group-active');
        $('.main-menu-content').find('li.active').closest('li.nav-item').addClass('open');
      }
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    },
    toggle: function toggle() {
      var currentBreakpoint = Unison.fetch.now(); // Current Breakpoint
      var collapsed = this.collapsed;
      var expanded = this.expanded;
      var hidden = this.hidden;
      var menu = $('body').data('menu');
      switch (currentBreakpoint.name) {
        case 'xl':
          if (expanded === true) {
            if (menu == 'vertical-overlay-menu') {
              this.hide();
            } else {
              this.collapse();
            }
          } else {
            if (menu == 'vertical-overlay-menu') {
              this.open();
            } else {
              this.expand();
            }
          }
          break;
        case 'lg':
          if (expanded === true) {
            if (menu == 'vertical-overlay-menu' || menu == 'vertical-menu-modern' || menu == 'horizontal-menu') {
              this.hide();
            } else {
              this.collapse();
            }
          } else {
            if (menu == 'vertical-overlay-menu' || menu == 'vertical-menu-modern' || menu == 'horizontal-menu') {
              this.open();
            } else {
              this.expand();
            }
          }
          break;
        case 'md':
        case 'sm':
          if (hidden === true) {
            this.open();
          } else {
            this.hide();
          }
          break;
        case 'xs':
          if (hidden === true) {
            this.open();
          } else {
            this.hide();
          }
          break;
      }
    },
    update: function update() {
      this.manualScroller.update();
    },
    reset: function reset() {
      this.expanded = false;
      this.collapsed = false;
      this.hidden = false;
      $('body').removeClass('menu-hide menu-open menu-collapsed menu-expanded');
    }
  };

  // Navigation Menu
  $.app.nav = {
    container: $('.navigation-main'),
    initialized: false,
    navItem: $('.navigation-main').find('li').not('.navigation-category'),
    TRANSITION_EVENTS: ['transitionend', 'webkitTransitionEnd', 'oTransitionEnd'],
    TRANSITION_PROPERTIES: ['transition', 'MozTransition', 'webkitTransition', 'WebkitTransition', 'OTransition'],
    config: {
      speed: 300
    },
    init: function init(config) {
      this.initialized = true; // Set to true when initialized
      $.extend(this.config, config);
      this.bind_events();
    },
    bind_events: function bind_events() {
      var menuObj = this;
      $(document).on('mouseenter.app.menu', '.navigation-main li', function () {
        var $this = $(this);
        // $('.hover', '.navigation-main').removeClass('hover');
        if ($('body').hasClass('menu-collapsed') && $('body').data('menu') != 'vertical-menu-modern') {
          $('.main-menu-content').children('span.menu-title').remove();
          $('.main-menu-content').children('a.menu-title').remove();
          $('.main-menu-content').children('ul.menu-content').remove();

          // Title
          var menuTitle = $this.find('span.menu-title').clone(),
            tempTitle,
            tempLink;
          if (!$this.hasClass('has-sub')) {
            tempTitle = $this.find('span.menu-title').text();
            tempLink = $this.children('a').attr('href');
            if (tempTitle !== '') {
              menuTitle = $('<a>');
              menuTitle.attr('href', tempLink);
              menuTitle.attr('title', tempTitle);
              menuTitle.text(tempTitle);
              menuTitle.addClass('menu-title');
            }
          }
          // menu_header_height = ($('.main-menu-header').length) ? $('.main-menu-header').height() : 0,
          // fromTop = menu_header_height + $this.position().top + parseInt($this.css( "border-top" ),10);
          var fromTop;
          if ($this.css('border-top')) {
            fromTop = $this.position().top + parseInt($this.css('border-top'), 10);
          } else {
            fromTop = $this.position().top;
          }
          if ($('body').data('menu') !== 'vertical-compact-menu') {
            menuTitle.appendTo('.main-menu-content').css({
              position: 'fixed',
              top: fromTop
            });
          }

          // Content
          /* if ($this.hasClass('has-sub') && $this.hasClass('nav-item')) {
           var menuContent = $this.children('ul:first');
           menuObj.adjustSubmenu($this);
           } */
        }
        // $this.addClass('hover');
      }).on('mouseleave.app.menu', '.navigation-main li', function () {
        // $(this).removeClass('hover');
      }).on('active.app.menu', '.navigation-main li', function (e) {
        $(this).addClass('active');
        e.stopPropagation();
      }).on('deactive.app.menu', '.navigation-main li.active', function (e) {
        $(this).removeClass('active');
        e.stopPropagation();
      }).on('open.app.menu', '.navigation-main li', function (e) {
        var $listItem = $(this);
        menuObj.expand($listItem);
        // $listItem.addClass('open');

        // If menu collapsible then do not take any action
        if ($('.main-menu').hasClass('menu-collapsible')) {
          return false;
        }
        // If menu accordion then close all except clicked once
        else {
          $listItem.siblings('.open').find('li.open').trigger('close.app.menu');
          $listItem.siblings('.open').trigger('close.app.menu');
        }
        e.stopPropagation();
      }).on('close.app.menu', '.navigation-main li.open', function (e) {
        var $listItem = $(this);
        menuObj.collapse($listItem);
        // $listItem.removeClass('open');

        e.stopPropagation();
      }).on('click.app.menu', '.navigation-main li', function (e) {
        var $listItem = $(this);
        if ($listItem.is('.disabled')) {
          e.preventDefault();
        } else {
          if ($('body').hasClass('menu-collapsed') && $('body').data('menu') != 'vertical-menu-modern') {
            e.preventDefault();
          } else {
            if ($listItem.has('ul').length) {
              if ($listItem.is('.open')) {
                $listItem.trigger('close.app.menu');
              } else {
                $listItem.trigger('open.app.menu');
              }
            } else {
              if (!$listItem.is('.active')) {
                $listItem.siblings('.active').trigger('deactive.app.menu');
                $listItem.trigger('active.app.menu');
              }
            }
          }
        }
        e.stopPropagation();
      });
      $(document).on('mouseenter', '.navbar-header, .main-menu', modernMenuExpand).on('mouseleave', '.navbar-header, .main-menu', modernMenuCollapse);
      function modernMenuExpand() {
        if ($('body').data('menu') == 'vertical-menu-modern') {
          $('.main-menu, .navbar-header').addClass('expanded');
          if ($('body').hasClass('menu-collapsed')) {
            if ($('.main-menu li.open').length === 0) {
              $('.main-menu-content').find('li.active').parents('li').addClass('open');
            }
            var $listItem = $('.main-menu li.menu-collapsed-open'),
              $subList = $listItem.children('ul');
            $subList.hide().slideDown(200, function () {
              $(this).css('display', '');
            });
            $listItem.addClass('open').removeClass('menu-collapsed-open');
            // $.app.menu.changeLogo('expand');
          }
        }
      }
      function modernMenuCollapse() {
        if ($('body').hasClass('menu-collapsed') && $('body').data('menu') == 'vertical-menu-modern') {
          setTimeout(function () {
            if ($('.main-menu:hover').length === 0 && $('.navbar-header:hover').length === 0) {
              $('.main-menu, .navbar-header').removeClass('expanded');
              if ($('body').hasClass('menu-collapsed')) {
                var $listItem = $('.main-menu li.open'),
                  $subList = $listItem.children('ul');
                $listItem.addClass('menu-collapsed-open');
                $subList.show().slideUp(200, function () {
                  $(this).css('display', '');
                });
                $listItem.removeClass('open');
                // $.app.menu.changeLogo();
              }
            }
          }, 1);
        }
      }
      $(document).on('mouseleave', '.main-menu-content', function () {
        if ($('body').hasClass('menu-collapsed')) {
          $('.main-menu-content').children('span.menu-title').remove();
          $('.main-menu-content').children('a.menu-title').remove();
          $('.main-menu-content').children('ul.menu-content').remove();
        }
        $('.hover', '.navigation-main').removeClass('hover');
      });

      // If list item has sub menu items then prevent redirection.
      $(document).on('click', '.navigation-main li.has-sub > a', function (e) {
        e.preventDefault();
      });
    },
    /**
     * Ensure an admin submenu is within the visual viewport.
     * @param {jQuery} $menuItem The parent menu item containing the submenu.
     */

    /* adjustSubmenu: function ($menuItem) {
     var menuHeaderHeight,
     menutop,
     topPos,
     winHeight,
     bottomOffset,
     subMenuHeight,
     popOutMenuHeight,
     borderWidth,
     scroll_theme,
     $submenu = $menuItem.children('ul:first'),
     ul = $submenu.clone(true);
      menuHeaderHeight = $('.main-menu-header').height();
     menutop = $menuItem.position().top;
     winHeight = $window.height() - $('.header-navbar').height();
     borderWidth = 0;
     subMenuHeight = $submenu.height();
      if (parseInt($menuItem.css('border-top'), 10) > 0) {
     borderWidth = parseInt($menuItem.css('border-top'), 10);
     }
      popOutMenuHeight = winHeight - menutop - $menuItem.height() - 30;
     scroll_theme = $('.main-menu').hasClass('menu-dark') ? 'light' : 'dark';
      topPos = menutop + $menuItem.height() + borderWidth;
      ul.addClass('menu-popout').appendTo('.main-menu-content').css({
     top: topPos,
     position: 'fixed',
     'max-height': popOutMenuHeight
     });
      var menu_content = new PerfectScrollbar('.main-menu-content > ul.menu-content', {
     wheelPropagation: false
     });
     }, */

    // Collapse Submenu With Transition (Height animation)
    collapse: function collapse($listItem, callback) {
      var subList = $listItem.children('ul'),
        toggleLink = $listItem.children().first(),
        linkHeight = $(toggleLink).outerHeight();
      $listItem.css({
        height: linkHeight + subList.outerHeight() + 'px',
        overflow: 'hidden'
      });
      $listItem.addClass('menu-item-animating');
      $listItem.addClass('menu-item-closing');
      $.app.nav._bindAnimationEndEvent($listItem, function () {
        $listItem.removeClass('open');
        $.app.nav._clearItemStyle($listItem);
      });
      setTimeout(function () {
        $listItem.css({
          height: linkHeight + 'px'
        });
      }, 50);
    },
    // Expand Submenu With Transition (Height animation)
    expand: function expand($listItem, callback) {
      var subList = $listItem.children('ul'),
        toggleLink = $listItem.children().first(),
        linkHeight = $(toggleLink).outerHeight();
      $listItem.addClass('menu-item-animating');
      $listItem.css({
        overflow: 'hidden',
        height: linkHeight + 'px'
      });
      $listItem.addClass('open');
      $.app.nav._bindAnimationEndEvent($listItem, function () {
        $.app.nav._clearItemStyle($listItem);
      });
      setTimeout(function () {
        $listItem.css({
          height: linkHeight + subList.outerHeight() + 'px'
        });
      }, 50);
    },
    _bindAnimationEndEvent: function _bindAnimationEndEvent(el, handler) {
      el = el[0];
      var cb = function cb(e) {
        if (e.target !== el) return;
        $.app.nav._unbindAnimationEndEvent(el);
        handler(e);
      };
      var duration = window.getComputedStyle(el).transitionDuration;
      duration = parseFloat(duration) * (duration.indexOf('ms') !== -1 ? 1 : 1000);
      el._menuAnimationEndEventCb = cb;
      $.app.nav.TRANSITION_EVENTS.forEach(function (ev) {
        el.addEventListener(ev, el._menuAnimationEndEventCb, false);
      });
      el._menuAnimationEndEventTimeout = setTimeout(function () {
        cb({
          target: el
        });
      }, duration + 50);
    },
    _unbindAnimationEndEvent: function _unbindAnimationEndEvent(el) {
      var cb = el._menuAnimationEndEventCb;
      if (el._menuAnimationEndEventTimeout) {
        clearTimeout(el._menuAnimationEndEventTimeout);
        el._menuAnimationEndEventTimeout = null;
      }
      if (!cb) return;
      $.app.nav.TRANSITION_EVENTS.forEach(function (ev) {
        el.removeEventListener(ev, cb, false);
      });
      el._menuAnimationEndEventCb = null;
    },
    _clearItemStyle: function _clearItemStyle($listItem) {
      $listItem.removeClass('menu-item-animating');
      $listItem.removeClass('menu-item-closing');
      $listItem.css({
        overflow: '',
        height: ''
      });
    },
    refresh: function refresh() {
      $.app.nav.container.find('.open').removeClass('open');
    }
  };

  // We listen to the resize event
  window.addEventListener('resize', function () {
    // We execute the same script as before
    var vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', vh + 'px');
  });
  $(document).on('click', '.menu-toggle, .modern-nav-toggle', function (e) {
    e.preventDefault();

    // Toggle menu
    $.app.menu.toggle();
    setTimeout(function () {
      $(window).trigger('resize');
    }, 200);
    if ($('#collapse-sidebar-switch').length > 0) {
      setTimeout(function () {
        if ($('body').hasClass('menu-expanded') || $('body').hasClass('menu-open')) {
          $('#collapse-sidebar-switch').prop('checked', false);
        } else {
          $('#collapse-sidebar-switch').prop('checked', true);
        }
      }, 50);
    }

    // Hides dropdown on click of menu toggle
    // $('[data-toggle="dropdown"]').dropdown('hide');

    return false;
  });
}); //end of document ready

window.initSidebar = function () {
  $(function () {
    var $html = $('html');
    var $body = $('body');
    var $textcolor = '#4e5154';
    var assetPath = '../../../app-assets/';
    var rtl;
    var compactMenu = false;
    if ($('body').hasClass('menu-collapsed')) {
      compactMenu = true;
    }
    if ($('html').data('textdirection') == 'rtl') {
      rtl = true;
    }
    setTimeout(function () {
      $html.removeClass('loading').addClass('loaded');
    }, 1200);
    $.app.menu.init(compactMenu);

    // Navigation configurations
    var config = {
      speed: 300 // set speed to expand / collpase menu
    };
    if ($.app.nav.initialized === false) {
      $.app.nav.init(config);
    }
    Unison.on('change', function (bp) {
      $.app.menu.change(compactMenu);
    });

    // Tooltip Initialization
    $('[data-toggle="tooltip"]').tooltip({
      container: 'body'
    });

    // Collapsible Card
    $(document).on('click', 'a[data-action="collapse"]', function (e) {
      e.preventDefault();
      $(this).closest('.card').children('.card-content').collapse('toggle');
      $(this).closest('.card').find('[data-action="collapse"]').toggleClass('rotate');
    });

    // Cart dropdown touchspin
    if ($('.touchspin-cart').length > 0) {
      $('.touchspin-cart').TouchSpin({
        buttondown_class: 'btn btn-primary',
        buttonup_class: 'btn btn-primary',
        buttondown_txt: feather.icons['minus'].toSvg(),
        buttonup_txt: feather.icons['plus'].toSvg()
      });
    }

    // Do not close cart or notification dropdown on click of the items
    $(document).on('click', '.dropdown-notification .dropdown-menu, .dropdown-cart .dropdown-menu', function (e) {
      e.stopPropagation();
    });

    //  Notifications & messages scrollable
    $('.scrollable-container').each(function () {
      var scrollable_container = new PerfectScrollbar($(this)[0], {
        wheelPropagation: false
      });
    });

    // Reload Card
    $(document).on('click', 'a[data-action="reload"]', function () {
      var block_ele = $(this).closest('.card');
      var reloadActionOverlay;
      if ($html.hasClass('dark-layout')) {
        var reloadActionOverlay = '#10163a';
      } else {
        var reloadActionOverlay = '#fff';
      }
      // Block Element
      block_ele.block({
        message: feather.icons['refresh-cw'].toSvg({
          "class": 'font-medium-1 spinner text-primary'
        }),
        timeout: 2000,
        //unblock after 2 seconds
        overlayCSS: {
          backgroundColor: reloadActionOverlay,
          cursor: 'wait'
        },
        css: {
          border: 0,
          padding: 0,
          backgroundColor: 'none'
        }
      });
    });

    // Close Card
    $(document).on('click', 'a[data-action="close"]', function () {
      $(this).closest('.card').removeClass().slideUp('fast');
    });
    $(document).on('click', '.card .heading-elements a[data-action="collapse"]', function () {
      var $this = $(this),
        card = $this.closest('.card');
      var cardHeight;
      if (parseInt(card[0].style.height, 10) > 0) {
        cardHeight = card.css('height');
        card.css('height', '').attr('data-height', cardHeight);
      } else {
        if (card.data('height')) {
          cardHeight = card.data('height');
          card.css('height', cardHeight).attr('data-height', '');
        }
      }
    });

    // Add disabled class to input group when input is disabled
    $('input:disabled, textarea:disabled').closest('.input-group').addClass('disabled');

    // Add sidebar group active class to active menu
    $('.main-menu-content').find('li.active').parents('li').addClass('sidebar-group-active');

    // Add open class to parent list item if subitem is active except compact menu
    var menuType = $('body').data('menu');
    if (menuType != 'horizontal-menu' && compactMenu === false) {
      $('.main-menu-content').find('li.active').parents('li').addClass('open');
    }
    if (menuType == 'horizontal-menu') {
      $('.main-menu-content').find('li.active').parents('li:not(.nav-item)').addClass('open');
      $('.main-menu-content').find('li.active').closest('li.nav-item').addClass('sidebar-group-active open');
      // $(".main-menu-content")
      //   .find("li.active")
      //   .parents("li")
      //   .addClass("active");
    }

    //  Dynamic height for the chartjs div for the chart animations to work
    var chartjsDiv = $('.chartjs'),
      canvasHeight = chartjsDiv.children('canvas').attr('height'),
      mainMenu = $('.main-menu');
    chartjsDiv.css('height', canvasHeight);
    if ($('body').hasClass('boxed-layout')) {
      if ($('body').hasClass('vertical-overlay-menu')) {
        var menuWidth = mainMenu.width();
        var contentPosition = $('.app-content').position().left;
        var menuPositionAdjust = contentPosition - menuWidth;
        if ($('body').hasClass('menu-flipped')) {
          mainMenu.css('right', menuPositionAdjust + 'px');
        } else {
          mainMenu.css('left', menuPositionAdjust + 'px');
        }
      }
    }

    //Custom File Input
    $('.custom-file-input').on('change', function (e) {
      $(this).siblings('.custom-file-label').html(e.target.files[0].name);
    });

    /* Text Area Counter Set Start */
    $('.char-textarea').on('keyup', function (event) {
      checkTextAreaMaxLength(this, event);
      // to later change text color in dark layout
      $(this).addClass('active');
    });

    /*
     Checks the MaxLength of the Textarea
     -----------------------------------------------------
     @prerequisite:  textBox = textarea dom element
     e = textarea event
     length = Max length of characters
     */
    function checkTextAreaMaxLength(textBox, e) {
      var maxLength = parseInt($(textBox).data('length')),
        counterValue = $('.textarea-counter-value'),
        charTextarea = $('.char-textarea');
      if (!checkSpecialKeys(e)) {
        if (textBox.value.length < maxLength - 1) textBox.value = textBox.value.substring(0, maxLength);
      }
      $('.char-count').html(textBox.value.length);
      if (textBox.value.length > maxLength) {
        counterValue.css('background-color', window.colors.solid.danger);
        charTextarea.css('color', window.colors.solid.danger);
        // to change text color after limit is maxedout out
        charTextarea.addClass('max-limit');
      } else {
        counterValue.css('background-color', window.colors.solid.primary);
        charTextarea.css('color', $textcolor);
        charTextarea.removeClass('max-limit');
      }
      return true;
    }

    /*
     Checks if the keyCode pressed is inside special chars
     -------------------------------------------------------
     @prerequisite:  e = e.keyCode object for the key pressed
     */
    function checkSpecialKeys(e) {
      if (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) return false;else return true;
    }
    $(document).on('click', '.content-overlay', function () {
      $('.search-list').removeClass('show');
      var searchInput = $('.search-input-close').closest('.search-input');
      if (searchInput.hasClass('open')) {
        searchInput.removeClass('open');
        searchInputInputfield.val('');
        searchInputInputfield.blur();
        searchList.removeClass('show');
      }
      $('.app-content').removeClass('show-overlay');
      $('.bookmark-wrapper .bookmark-input').removeClass('show');
    });

    // To show shadow in main menu when menu scrolls
    var container = document.getElementsByClassName('main-menu-content');
    if (container.length > 0) {
      container[0].addEventListener('ps-scroll-y', function () {
        if ($(this).find('.ps__thumb-y').position().top > 0) {
          // $('.shadow-bottom').css('display', 'block');
        } else {
          // $('.shadow-bottom').css('display', 'none');
        }
      });
    }

    // Hide overlay menu on content overlay click on small screens
    $(document).on('click', '.sidenav-overlay', function (e) {
      // Hide menu
      $.app.menu.hide();
      return false;
    });

    // Execute below code only if we find hammer js for touch swipe feature on small screen
    if (typeof Hammer !== 'undefined') {
      var rtl;
      if ($('html').data('textdirection') == 'rtl') {
        rtl = true;
      }

      // Swipe menu gesture
      var swipeInElement = document.querySelector('.drag-target'),
        swipeInAction = 'panright',
        swipeOutAction = 'panleft';
      if (rtl === true) {
        swipeInAction = 'panleft';
        swipeOutAction = 'panright';
      }
      if ($(swipeInElement).length > 0) {
        var swipeInMenu = new Hammer(swipeInElement);
        swipeInMenu.on(swipeInAction, function (ev) {
          if ($('body').hasClass('vertical-overlay-menu')) {
            $.app.menu.open();
            return false;
          }
        });
      }

      // menu swipe out gesture
      setTimeout(function () {
        var swipeOutElement = document.querySelector('.main-menu');
        var swipeOutMenu;
        if ($(swipeOutElement).length > 0) {
          swipeOutMenu = new Hammer(swipeOutElement);
          swipeOutMenu.get('pan').set({
            direction: Hammer.DIRECTION_ALL,
            threshold: 250
          });
          swipeOutMenu.on(swipeOutAction, function (ev) {
            if ($('body').hasClass('vertical-overlay-menu')) {
              $.app.menu.hide();
              return false;
            }
          });
        }
      }, 300);

      // menu close on overlay tap
      var swipeOutOverlayElement = document.querySelector('.sidenav-overlay');
      if ($(swipeOutOverlayElement).length > 0) {
        var swipeOutOverlayMenu = new Hammer(swipeOutOverlayElement);
        swipeOutOverlayMenu.on('tap', function (ev) {
          if ($('body').hasClass('vertical-overlay-menu')) {
            $.app.menu.hide();
            return false;
          }
        });
      }
    }

    // Add Children Class
    $('.navigation').find('li').has('ul').addClass('has-sub');
    $('.carousel').carousel({
      interval: 2000
    });

    // Update manual scroller when window is resized
    $(window).resize(function () {
      $.app.menu.manualScroller.updateHeight();
    });
    $(document).on('click', '#sidebar-page-navigation a.nav-link', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var $this = $(this),
        href = $this.attr('href');
      var offset = $(href).offset();
      var scrollto = offset.top - 80; // minus fixed header height
      $('html, body').animate({
        scrollTop: scrollto
      }, 0);
      setTimeout(function () {
        $this.parent('.nav-item').siblings('.nav-item').children('.nav-link').removeClass('active');
        $this.addClass('active');
      }, 100);
    });

    // main menu internationalization

    // init i18n and load language file
    if ($('body').attr('data-framework') === 'laravel') {
      // change language according to data-language of dropdown item
      var language = $('html')[0].lang;
      if (language !== null) {
        // get the selected flag class
        var selectedLang = $('.dropdown-language').find('a[data-language=' + language + ']').text();
        var selectedFlag = $('.dropdown-language').find('a[data-language=' + language + '] .flag-icon').attr('class');
        // set the class in button
        $('#dropdown-flag .selected-language').text(selectedLang);
        $('#dropdown-flag .flag-icon').removeClass().addClass(selectedFlag);
      }
    } else {
      // i18next.use(window.i18nextXHRBackend).init(
      //     {
      //         debug: false,
      //         fallbackLng: 'en',
      //         backend: {
      //             loadPath: assetPath + 'data/locales/{{lng}}.json'
      //         },
      //         returnObjects: true
      //     },
      //     function (err, t) {
      //         // resources have been loaded
      //         jqueryI18next.init(i18next, $);
      //     }
      // );

      // change language according to data-language of dropdown item
      $(document).on('click', '.dropdown-language .dropdown-item', function () {
        var $this = $(this);
        $this.siblings('.selected').removeClass('selected');
        $this.addClass('selected');
        var selectedLang = $this.text();
        var selectedFlag = $this.find('.flag-icon').attr('class');
        $('#dropdown-flag .selected-language').text(selectedLang);
        $('#dropdown-flag .flag-icon').removeClass().addClass(selectedFlag);
        var currentLanguage = $this.data('language');
        i18next.changeLanguage(currentLanguage, function (err, t) {
          $('.main-menu, .horizontal-menu-wrapper').localize();
        });
      });
    }

    /********************* Bookmark & Search ***********************/
    // This variable is used for mouseenter and mouseleave events of search list
    var $filename = $('.search-input input').data('search'),
      bookmarkWrapper = $('.bookmark-wrapper'),
      bookmarkStar = $('.bookmark-wrapper .bookmark-star'),
      bookmarkInput = $('.bookmark-wrapper .bookmark-input'),
      navLinkSearch = $('.nav-link-search'),
      searchInput = $('.search-input'),
      searchInputInputfield = $('.search-input input'),
      searchList = $('.search-input .search-list'),
      appContent = $('.app-content'),
      bookmarkSearchList = $('.bookmark-input .search-list');

    // Bookmark icon click
    bookmarkStar.on('click', function (e) {
      e.stopPropagation();
      bookmarkInput.toggleClass('show');
      bookmarkInput.find('input').val('');
      bookmarkInput.find('input').blur();
      bookmarkInput.find('input').focus();
      bookmarkWrapper.find('.search-list').addClass('show');
      var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
        $arrList = '',
        $activeItemClass = '';
      $('ul.search-list li').remove();
      for (var i = 0; i < arrList.length; i++) {
        if (i === 0) {
          $activeItemClass = 'current_item';
        } else {
          $activeItemClass = '';
        }
        var iconName = '',
          className = '';
        if ($(arrList[i].firstChild.firstChild).hasClass('feather')) {
          var classString = arrList[i].firstChild.firstChild.getAttribute('class');
          iconName = classString.split('feather-')[1].split(' ')[0];
          className = classString.split('feather-')[1].split(' ')[1];
        }
        $arrList += '<li class="auto-suggestion ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + arrList[i].firstChild.href + '>' + '<div class="d-flex justify-content-start align-items-center">' + feather.icons[iconName].toSvg({
          "class": 'mr-75 ' + className
        }) + '<span>' + arrList[i].firstChild.dataset.originalTitle + '</span>' + '</div>' + feather.icons['star'].toSvg({
          "class": 'text-warning bookmark-icon float-right'
        }) + '</a>' + '</li>';
      }
      $('ul.search-list').append($arrList);
    });

    // Navigation Search area Open
    navLinkSearch.on('click', function () {
      var $this = $(this);
      var searchInput = $(this).parent('.nav-search').find('.search-input');
      searchInput.addClass('open');
      searchInputInputfield.focus();
      searchList.find('li').remove();
      bookmarkInput.removeClass('show');
    });

    // Navigation Search area Close
    $(document).on('click', '.search-input-close', function () {
      var $this = $(this),
        searchInput = $(this).closest('.search-input');
      if (searchInput.hasClass('open')) {
        searchInput.removeClass('open');
        searchInputInputfield.val('');
        searchInputInputfield.blur();
        searchList.removeClass('show');
        appContent.removeClass('show-overlay');
      }
    });

    // Filter
    if ($('.search-list-main').length) {
      var searchListMain = new PerfectScrollbar('.search-list-main', {
        wheelPropagation: false
      });
    }
    if ($('.search-list-bookmark').length) {
      var searchListBookmark = new PerfectScrollbar('.search-list-bookmark', {
        wheelPropagation: false
      });
    }
    // update Perfect Scrollbar on hover
    $(document).on('mouseenter', '.search-list-main', function () {
      searchListMain.update();
    });
    searchInputInputfield.on('keyup', function (e) {
      $(this).closest('.search-list').addClass('show');
      if (e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 13) {
        if (e.keyCode == 27) {
          appContent.removeClass('show-overlay');
          bookmarkInput.find('input').val('');
          bookmarkInput.find('input').blur();
          searchInputInputfield.val('');
          searchInputInputfield.blur();
          searchInput.removeClass('open');
          if (searchInput.hasClass('show')) {
            $(this).removeClass('show');
            searchInput.removeClass('show');
          }
        }

        // Define variables
        var value = $(this).val().toLowerCase(),
          //get values of input on keyup
          activeClass = '',
          bookmark = false,
          liList = $('ul.search-list li'); // get all the list items of the search
        liList.remove();
        // To check if current is bookmark input
        if ($(this).parent().hasClass('bookmark-input')) {
          bookmark = true;
        }

        // If input value is blank
        if (value != '') {
          appContent.addClass('show-overlay');

          // condition for bookmark and search input click
          if (bookmarkInput.focus()) {
            bookmarkSearchList.addClass('show');
          } else {
            searchList.addClass('show');
            bookmarkSearchList.removeClass('show');
          }
          if (bookmark === false) {
            searchList.addClass('show');
            bookmarkSearchList.removeClass('show');
          }
          var $startList = '',
            $otherList = '',
            $htmlList = '',
            $bookmarkhtmlList = '',
            $pageList = '<li class="d-flex align-items-center">' + '<a href="javascript:void(0)">' + '<h6 class="section-label mt-75 mb-0">Pages</h6>' + '</a>' + '</li>',
            $activeItemClass = '',
            $bookmarkIcon = '',
            $defaultList = '',
            a = 0;

          // getting json data from file for search results
          $.getJSON(assetPath + 'data/' + $filename + '.json', function (data) {
            for (var i = 0; i < data.listItems.length; i++) {
              // if current is bookmark then give class to star icon
              // for laravel
              if ($('body').attr('data-framework') === 'laravel') {
                data.listItems[i].url = assetPath + data.listItems[i].url;
              }
              if (bookmark === true) {
                activeClass = ''; // resetting active bookmark class
                var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
                  $arrList = '';
                // Loop to check if current seach value match with the bookmarks already there in navbar
                for (var j = 0; j < arrList.length; j++) {
                  if (data.listItems[i].name === arrList[j].firstChild.dataset.originalTitle) {
                    activeClass = ' text-warning';
                    break;
                  } else {
                    activeClass = '';
                  }
                }
                $bookmarkIcon = feather.icons['star'].toSvg({
                  "class": 'bookmark-icon float-right' + activeClass
                });
              }
              // Search list item start with entered letters and create list
              if (data.listItems[i].name.toLowerCase().indexOf(value) == 0 && a < 5) {
                if (a === 0) {
                  $activeItemClass = 'current_item';
                } else {
                  $activeItemClass = '';
                }
                $startList += '<li class="auto-suggestion ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + data.listItems[i].url + '>' + '<div class="d-flex justify-content-start align-items-center">' + feather.icons[data.listItems[i].icon].toSvg({
                  "class": 'mr-75 '
                }) + '<span>' + data.listItems[i].name + '</span>' + '</div>' + $bookmarkIcon + '</a>' + '</li>';
                a++;
              }
            }
            for (var i = 0; i < data.listItems.length; i++) {
              if (bookmark === true) {
                activeClass = ''; // resetting active bookmark class
                var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
                  $arrList = '';
                // Loop to check if current search value match with the bookmarks already there in navbar
                for (var j = 0; j < arrList.length; j++) {
                  if (data.listItems[i].name === arrList[j].firstChild.dataset.originalTitle) {
                    activeClass = ' text-warning';
                  } else {
                    activeClass = '';
                  }
                }
                $bookmarkIcon = feather.icons['star'].toSvg({
                  "class": 'bookmark-icon float-right' + activeClass
                });
              }
              // Search list item not start with letters and create list
              if (!(data.listItems[i].name.toLowerCase().indexOf(value) == 0) && data.listItems[i].name.toLowerCase().indexOf(value) > -1 && a < 5) {
                if (a === 0) {
                  $activeItemClass = 'current_item';
                } else {
                  $activeItemClass = '';
                }
                $otherList += '<li class="auto-suggestion ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + data.listItems[i].url + '>' + '<div class="d-flex justify-content-start align-items-center">' + feather.icons[data.listItems[i].icon].toSvg({
                  "class": 'mr-75 '
                }) + '<span>' + data.listItems[i].name + '</span>' + '</div>' + $bookmarkIcon + '</a>' + '</li>';
                a++;
              }
            }
            $defaultList = $('.main-search-list-defaultlist').html();
            if ($startList == '' && $otherList == '') {
              $otherList = $('.main-search-list-defaultlist-other-list').html();
            }
            // concatinating startlist, otherlist, defalutlist with pagelist
            $htmlList = $pageList.concat($startList, $otherList, $defaultList);
            $('ul.search-list').html($htmlList);
            // concatinating otherlist with startlist
            $bookmarkhtmlList = $startList.concat($otherList);
            $('ul.search-list-bookmark').html($bookmarkhtmlList);
            // Feather Icons
            // if (feather) {
            //   featherSVG();
            // }
          });
        } else {
          if (bookmark === true) {
            var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
              $arrList = '';
            for (var i = 0; i < arrList.length; i++) {
              if (i === 0) {
                $activeItemClass = 'current_item';
              } else {
                $activeItemClass = '';
              }
              var iconName = '',
                className = '';
              if ($(arrList[i].firstChild.firstChild).hasClass('feather')) {
                var classString = arrList[i].firstChild.firstChild.getAttribute('class');
                iconName = classString.split('feather-')[1].split(' ')[0];
                className = classString.split('feather-')[1].split(' ')[1];
              }
              $arrList += '<li class="auto-suggestion">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + arrList[i].firstChild.href + '>' + '<div class="d-flex justify-content-start align-items-center">' + feather.icons[iconName].toSvg({
                "class": 'mr-75 '
              }) + '<span>' + arrList[i].firstChild.dataset.originalTitle + '</span>' + '</div>' + feather.icons['star'].toSvg({
                "class": 'text-warning bookmark-icon float-right'
              }) + '</a>' + '</li>';
            }
            $('ul.search-list').append($arrList);
            // Feather Icons
            // if (feather) {
            //   featherSVG();
            // }
          } else {
            // if search input blank, hide overlay
            if (appContent.hasClass('show-overlay')) {
              appContent.removeClass('show-overlay');
            }
            // If filter box is empty
            if (searchList.hasClass('show')) {
              searchList.removeClass('show');
            }
          }
        }
      }
    });

    // Add class on hover of the list
    $(document).on('mouseenter', '.search-list li', function (e) {
      $(this).siblings().removeClass('current_item');
      $(this).addClass('current_item');
    });
    $(document).on('click', '.search-list li', function (e) {
      e.stopPropagation();
    });
    $(document).on('click', 'html', function ($this) {
      if (!$($this.target).hasClass('bookmark-icon')) {
        if (bookmarkSearchList.hasClass('show')) {
          bookmarkSearchList.removeClass('show');
        }
        if (bookmarkInput.hasClass('show')) {
          bookmarkInput.removeClass('show');
        }
      }
    });

    // Prevent closing bookmark dropdown on input textbox click
    $(document).on('click', '.bookmark-input input', function (e) {
      bookmarkInput.addClass('show');
      bookmarkSearchList.addClass('show');
    });

    // Favorite star click
    $(document).on('click', '.bookmark-input .search-list .bookmark-icon', function (e) {
      e.stopPropagation();
      if ($(this).hasClass('text-warning')) {
        $(this).removeClass('text-warning');
        var arrList = $('ul.nav.navbar-nav.bookmark-icons li');
        for (var i = 0; i < arrList.length; i++) {
          if (arrList[i].firstChild.dataset.originalTitle == $(this).parent()[0].innerText) {
            arrList[i].remove();
          }
        }
        e.preventDefault();
      } else {
        var arrList = $('ul.nav.navbar-nav.bookmark-icons li');
        $(this).addClass('text-warning');
        e.preventDefault();
        var $url = $(this).parent()[0].href,
          $name = $(this).parent()[0].innerText,
          $listItem = '',
          $listItemDropdown = '',
          iconName = $(this).parent()[0].firstChild.firstChild.dataset.icon;
        if ($($(this).parent()[0].firstChild.firstChild).hasClass('feather')) {
          var classString = $(this).parent()[0].firstChild.firstChild.getAttribute('class');
          iconName = classString.split('feather-')[1].split(' ')[0];
        }
        $listItem = '<li class="nav-item d-none d-lg-block">' + '<a class="nav-link" href="' + $url + '" data-toggle="tooltip" data-placement="top" title="" data-original-title="' + $name + '">' + feather.icons[iconName].toSvg({
          "class": 'ficon'
        }) + '</a>' + '</li>';
        $('ul.nav.bookmark-icons').append($listItem);
        $('[data-toggle="tooltip"]').tooltip();
      }
    });

    // If we use up key(38) Down key (40) or Enter key(13)
    $(window).on('keydown', function (e) {
      var $current = $('.search-list li.current_item'),
        $next,
        $prev;
      if (e.keyCode === 40) {
        $next = $current.next();
        $current.removeClass('current_item');
        $current = $next.addClass('current_item');
      } else if (e.keyCode === 38) {
        $prev = $current.prev();
        $current.removeClass('current_item');
        $current = $prev.addClass('current_item');
      }
      if (e.keyCode === 13 && $('.search-list li.current_item').length > 0) {
        var selected_item = $('.search-list li.current_item a');
        window.location = selected_item.attr('href');
        $(selected_item).trigger('click');
      }
    });

    // Waves Effect
    Waves.init();
    Waves.attach(".btn:not([class*='btn-relief-']):not([class*='btn-gradient-']):not([class*='btn-outline-']):not([class*='btn-flat-'])", ['waves-float', 'waves-light']);
    Waves.attach("[class*='btn-outline-']");
    Waves.attach("[class*='btn-flat-']");
    $(document).on('click', '.form-password-toggle .input-group-text', function (e) {
      e.preventDefault();
      var $this = $(this),
        inputGroupText = $this.closest('.form-password-toggle'),
        formPasswordToggleIcon = $this,
        formPasswordToggleInput = inputGroupText.find('input');
      if (formPasswordToggleInput.attr('type') === 'text') {
        formPasswordToggleInput.attr('type', 'password');
        if (feather) {
          formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye'].toSvg({
            "class": 'font-small-4'
          }));
        }
      } else if (formPasswordToggleInput.attr('type') === 'password') {
        formPasswordToggleInput.attr('type', 'text');
        if (feather) {
          formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye-off'].toSvg({
            "class": 'font-small-4'
          }));
        }
      }
    });

    // on window scroll button show/hide
    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 400) {
        $('.scroll-top').fadeIn();
      } else {
        $('.scroll-top').fadeOut();
      }

      // On Scroll navbar color on horizontal menu
      if ($('body').hasClass('navbar-static')) {
        var scroll = $(window).scrollTop();
        if (scroll > 65) {
          $('html:not(.dark-layout) .horizontal-menu .header-navbar.navbar-fixed').css({
            background: '#fff',
            'box-shadow': '0 4px 20px 0 rgba(0,0,0,.05)'
          });
          $('.horizontal-menu.dark-layout .header-navbar.navbar-fixed').css({
            background: '#161d31',
            'box-shadow': '0 4px 20px 0 rgba(0,0,0,.05)'
          });
          $('html:not(.dark-layout) .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#fff');
          $('.dark-layout .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#161d31');
        } else {
          $('html:not(.dark-layout) .horizontal-menu .header-navbar.navbar-fixed').css({
            background: '#f8f8f8',
            'box-shadow': 'none'
          });
          $('.dark-layout .horizontal-menu .header-navbar.navbar-fixed').css({
            background: '#161d31',
            'box-shadow': 'none'
          });
          $('html:not(.dark-layout) .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#fff');
          $('.dark-layout .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#161d31');
        }
      }
    });

    // Click event to scroll to top
    $(document).on('click', '.scroll-top', function () {
      $('html, body').animate({
        scrollTop: 0
      }, 1000);
    });
    function getCurrentLayout() {
      var currentLayout = '';
      if ($html.hasClass('dark-layout')) {
        currentLayout = 'dark-layout';
      } else if ($html.hasClass('bordered-layout')) {
        currentLayout = 'bordered-layout';
      } else if ($html.hasClass('semi-dark-layout')) {
        currentLayout = 'semi-dark-layout';
      } else {
        currentLayout = 'light-layout';
      }
      return currentLayout;
    }

    // Get the data layout, for blank set to light layout
    var dataLayout = $html.attr('data-layout') ? $html.attr('data-layout') : 'light-layout';

    // Navbar Dark / Light Layout Toggle Switch
    $(document).on('click', '.nav-link-style', function (e) {
      var currentLayout = getCurrentLayout(),
        switchToLayout = '',
        prevLayout = localStorage.getItem(dataLayout + '-prev-skin', currentLayout);

      // If currentLayout is not dark layout
      if (currentLayout !== 'dark-layout') {
        // Switch to dark
        switchToLayout = 'dark-layout';
      } else {
        // Switch to light
        switchToLayout = prevLayout ? prevLayout : 'light-layout';
      }
      var url = $('meta[name="layout-switch-route"]').attr('content');
      $.ajax({
        url: url,
        data: {
          'layout': switchToLayout
        },
        //processData: false,
        //contentType: false,
        cache: false,
        success: function success() {}
      }); //end of ajax call

      // Set Previous skin in local db
      // localStorage.setItem(dataLayout + '-prev-skin', currentLayout);
      // Set Current skin in local db
      // localStorage.setItem(dataLayout + '-current-skin', switchToLayout);

      // Call set layout
      setLayout(switchToLayout);

      // ToDo: Customizer fix
      $('.horizontal-menu .header-navbar.navbar-fixed').css({
        background: 'inherit',
        'box-shadow': 'inherit'
      });
      $('.horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', 'inherit');
    });

    // Get current local storage layout
    var currentLocalStorageLayout = localStorage.getItem(dataLayout + '-current-skin');

    // Set layout on screen load
    //? Comment it if you don't want to sync layout with local db
    // setLayout(currentLocalStorageLayout);

    function setLayout(currentLocalStorageLayout) {
      var navLinkStyle = $('.nav-link-style'),
        currentLayout = getCurrentLayout(),
        mainMenu = $('.main-menu'),
        navbar = $('.header-navbar'),
        // Witch to local storage layout if we have else current layout
        switchToLayout = currentLocalStorageLayout ? currentLocalStorageLayout : currentLayout;
      $html.removeClass('semi-dark-layout dark-layout bordered-layout');
      if (switchToLayout === 'dark-layout') {
        $html.addClass('dark-layout');
        mainMenu.removeClass('menu-light').addClass('menu-dark');
        navbar.removeClass('navbar-light').addClass('navbar-dark');
        navLinkStyle.find('.ficon').replaceWith(feather.icons['sun'].toSvg({
          "class": 'ficon'
        }));
      } else if (switchToLayout === 'bordered-layout') {
        $html.addClass('bordered-layout');
        mainMenu.removeClass('menu-dark').addClass('menu-light');
        navbar.removeClass('navbar-dark').addClass('navbar-light');
        navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({
          "class": 'ficon'
        }));
      } else if (switchToLayout === 'semi-dark-layout') {
        $html.addClass('semi-dark-layout');
        mainMenu.removeClass('menu-dark').addClass('menu-light');
        navbar.removeClass('navbar-dark').addClass('navbar-light');
        navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({
          "class": 'ficon'
        }));
      } else {
        $html.addClass('light-layout');
        mainMenu.removeClass('menu-dark').addClass('menu-light');
        navbar.removeClass('navbar-dark').addClass('navbar-light');
        navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({
          "class": 'ficon'
        }));
      }
      // Set radio in customizer if we have
      if ($('input:radio[data-layout=' + switchToLayout + ']').length > 0) {
        setTimeout(function () {
          $('input:radio[data-layout=' + switchToLayout + ']').prop('checked', true);
        });
      }
    }
  });

  // To use feather svg icons with different sizes
  function featherSVG(iconSize) {
    // Feather Icons
    if (iconSize == undefined) {
      iconSize = '14';
    }
    return feather.replace({
      width: iconSize,
      height: iconSize
    });
  }

  // jQuery Validation Global Defaults
  if (typeof jQuery.validator === 'function') {
    jQuery.validator.setDefaults({
      errorElement: 'span',
      errorPlacement: function errorPlacement(error, element) {
        if (element.parent().hasClass('input-group') || element.hasClass('select2') || element.attr('type') === 'checkbox') {
          error.insertAfter(element.parent());
        } else if (element.hasClass('custom-control-input')) {
          error.insertAfter(element.parent().siblings(':last'));
        } else {
          error.insertAfter(element);
        }
        if (element.parent().hasClass('input-group')) {
          element.parent().addClass('is-invalid');
        }
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).addClass('error');
        if ($(element).parent().hasClass('input-group')) {
          $(element).parent().addClass('is-invalid');
        }
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).removeClass('error');
        if ($(element).parent().hasClass('input-group')) {
          $(element).parent().removeClass('is-invalid');
        }
      }
    });
  }

  // Add validation class to input-group (input group validation fix, currently disabled but will be useful in future)
  /* function inputGroupValidation(el) {
   var validEl,
   invalidEl,
   elem = $(el);
    if (elem.hasClass('form-control')) {
   if ($(elem).is('.form-control:valid, .form-control.is-valid')) {
   validEl = elem;
   }
   if ($(elem).is('.form-control:invalid, .form-control.is-invalid')) {
   invalidEl = elem;
   }
   } else {
   validEl = elem.find('.form-control:valid, .form-control.is-valid');
   invalidEl = elem.find('.form-control:invalid, .form-control.is-invalid');
   }
   if (validEl !== undefined) {
   validEl.closest('.input-group').removeClass('.is-valid is-invalid').addClass('is-valid');
   }
   if (invalidEl !== undefined) {
   invalidEl.closest('.input-group').removeClass('.is-valid is-invalid').addClass('is-invalid');
   }
   } */
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*******************************************************!*\
  !*** ./public/admin_assets/custom/js/shared/index.js ***!
  \*******************************************************/
$(function () {
  initLiveWireHooks();
  initAjaxHeader();
  ajaxData();

  // initSelect2();

  // initDatePicker();

  initGalleryImages();
  ajaxModal();
  ajaxForm();
  disabledLinks();
  dataTableRecordSelect();
  showImageUnderFileExplorer();

  // checkFieldLanguage();

  toggleActive();
}); //end of document ready

var initLiveWireHooks = function initLiveWireHooks() {
  $(document).on('livewire:navigating', function (event) {
    window.destroySelect2();
    window.destroyDataTable();
  });
  $(document).on('livewire:navigated', function (event) {
    window.initSidebar();
    feather.replace();
    window.initSelect2();
    window.initDatePicker();
    $('input[autofocus]').focus();
  });
};
window.destroySelect2 = function () {
  $('select').each(function () {
    if ($(this).data('select2') != undefined) {
      $(this).select2('destroy');
    }
  });
};
window.destroyDataTable = function () {
  $('.datatable').DataTable().destroy();
};
var initAjaxHeader = function initAjaxHeader() {
  var loginUrl = $('meta[name="login-url"]').attr('content');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function error(xhr, status, _error) {
      if (xhr.status == 500) {
        window.handleErrorModal(xhr);
      } else if (xhr.status == 401 || xhr.status == 415 || xhr.status == 419) {
        window.location.href = loginUrl;
      }
    },
    statusCode: {}
  });
};
var ajaxData = function ajaxData() {
  $(document).on('click', '.ajax-data', function () {
    var loadingHtml = "\n              <div style=\"height: 50vh;\" class=\"d-flex justify-content-center align-items-center\">\n                  <div class=\"loader\"></div>\n              </div>\n        ";
    $('.ajax-data').removeClass('active');
    $(this).addClass('active');
    $('#ajax-data-wrapper').empty().append(loadingHtml);
    var url = $(this).data('url');
    $.ajax({
      url: url,
      cache: false,
      success: function success(html) {
        $('#ajax-data-wrapper').empty().append(html);
        window.initSelect2();
        window.initDatePicker();
        feather.replace();
      }
    }); //end of ajax call
  }); //end of on click
};
window.initSelect2 = function () {
  $('.select2').each(function () {
    var placeholder = $(this).find('option:first').text();
    if ($(this).attr('placeholder')) {
      placeholder = $(this).attr('placeholder');
    } //end of if

    $(this).select2({
      'width': '100%',
      'placeholder': placeholder
    });
  });

  // $('.select2-ajax').each(function () {
  //
  //     let searchUrl = $(this).attr('data-search-url');
  //     let placeholder = $(this).attr('placeholder');
  //     let loadingText = $(this).attr('data-loading-text');
  //
  //     $(this).select2({
  //         placeholder: placeholder,
  //         ajax: {
  //             url: searchUrl,
  //             delay: 250,
  //             dataType: 'json',
  //             data: function (params) {
  //                 return {
  //                     'search': params.term,
  //                     // 'not_in_names': that.val(),
  //                 };
  //             },
  //             processResults: function (data, params) {
  //                 data = data.data;
  //
  //                 return {
  //                     results: $.map(data, function (item) {
  //                         return {
  //                             text: item.title,
  //                             id: item.id,
  //                             image_asset_path: item.image_asset_path,
  //                             description: item.description.substring(0, 200),
  //                         }
  //                     })
  //                 }
  //             },
  //         },
  //         minimumInputLength: 1,
  //         escapeMarkup: function (markup) {
  //             return markup;
  //         },
  //         createTag: function (params) {
  //             return {
  //                 id: params.term,
  //                 text: params.term,
  //             };
  //         },
  //         templateResult: select2TemplateResult,
  //         templateSelection: select2TemplateSelection,
  //     });
  //
  // })

  var select2TemplateResult = function select2TemplateResult(data) {
    var el = '';
    if (data.loading) {
      var html = "\n            <div class=\"d-flex justify-content-between\">\n                <p style=\"font-size: 1.1rem; margin-bottom: 0;\">loading..</p>\n                 <div class=\"loading-container p-0\">\n                    <div class=\"loader-xs\"></div>\n                </div>\n            </div>\n        ";
      el = $(html);
    } else {
      var _html = "\n            <div class=\"d-flex\"> \n                <img src=\"".concat(data.image_asset_path, "\" style=\"width: 80px; height: 100px;\" alt=\"\">\n               \n                <div style=\"margin-left: 10px;\">\n                    <h4>").concat(data.text, "</h4>\n                    <p>").concat(data.description, "</p>\n                </div>\n            </div>\n        ");
      el = $(_html);
    }
    return el;
  };
  var select2TemplateSelection = function select2TemplateSelection(data) {
    var el = '';
    if (data.newOption & !data.addedBefore) {
      var html = "<span>".concat(data.text, "</div>");
      $.ajax({
        url: data.creationUrl,
        method: 'POST',
        data: {
          'name': data.text
        },
        cache: false,
        success: function success(resp) {
          data.addedBefore = true;
        }
      }); //end of ajax call

      el = $(html);
    } else {
      var _html2 = "<span>".concat(data.text, "</div>");
      el = $(_html2);
    }
    return el;
  };
};
var ajaxModal = function ajaxModal() {
  $('#ajax-modal').on('hide.bs.modal', function (e) {
    $('#ajax-modal .modal-body').empty();
    window.destroySelect2();
    window.initSelect2();
  });
  $(document).on('click', '.ajax-modal', function (e) {
    e.preventDefault();
    var loading = "\n            <div class=\"loading-container absolute-centered\">\n                <div class=\"loader sm\"></div>\n            </div>\n        ";
    var url = $(this).data('url');
    var modalTitle = $(this).data('modal-title');
    var modalBodyClass = $(this).data('modal-body-class');
    $('#ajax-modal').modal('show');
    $('#ajax-modal .modal-body').remove();
    $('#ajax-modal .modal-content').append('<div class="modal-body relative"></div>');
    $('#ajax-modal .modal-body').addClass(modalBodyClass);
    $('#ajax-modal .modal-body').empty().append(loading);
    $('#ajax-modal .modal-title').text(modalTitle);
    window.destroySelect2();
    $.ajax({
      url: url,
      //processData: false,
      //contentType: false,
      cache: false,
      success: function success(response) {
        $('#ajax-modal .modal-body').empty().append(response['view']);
        window.initSelect2();
        window.initDatePicker();
        feather.replace();
      }
    }); //end of ajax call
  });
};
var ajaxForm = function ajaxForm() {
  $(document).on('submit', '.ajax-form', function (e) {
    e.preventDefault();
    var that = $(this);
    var loading = $('meta[name="loading"]').attr('content');
    var submitButton = that.find('button[type="submit"]:last-child');
    var submitButtonHtml = submitButton.html();
    submitButton.attr('disabled', true);
    that.find('button[type="submit"]').html(loading);
    that.removeClass('active');
    that.addClass('active');
    that.find('.invalid-feedback').remove();
    var url = $(this).attr('action');
    var data = new FormData(this);
    $('.ajax-form.active .invalid-feedback').hide();
    $.ajax({
      url: url,
      data: data,
      method: 'POST',
      contentType: false,
      processData: false,
      cache: false,
      success: function success(response) {
        hideModals();
        handleAjaxRedirects(response, submitButtonHtml);
        handleAjaxRemoveElements(response);
        handleRefreshDatatable();
        if (that.hasClass('empty-form')) {
          that.find('input:not([type=hidden]), textarea, select').val('');
        } //end of if
      },
      error: function error(xhr, exception) {
        var loginUrl = $('meta[name="login-url"]').attr('content');
        if (xhr.status == 500) {
          window.handleErrorModal(xhr);
        } else if (xhr.status == 401 || xhr.status == 415 || xhr.status == 419) {
          window.location.href = loginUrl;
        } else {
          handleAjaxErrors(xhr, submitButtonHtml);
        } //end of if
      },
      complete: function complete() {
        submitButton.attr('disabled', false);
        submitButton.html(submitButtonHtml);
      }
    }); //end of ajax call
  });
};
window.hideModals = function () {
  $(".modal:not(#ajax-modal)").each(function () {
    $(this).modal("hide");
  });
  $(".modal#ajax-modal").each(function () {
    $(this).modal("hide");
    $('#ajax-modal .modal-body').empty();
    window.destroySelect2();
    window.initSelect2();
  });
};
window.handleErrorModal = function (xhr) {
  $('#error-modal').modal('show');
  var html = '';
  if (xhr.responseJSON) {
    var error = xhr.responseJSON;
    html += "\n            <h3> ".concat(error.message, "</h3>\n            <p><strong>Exception: </strong>").concat(error.exception, "</p>\n            <p><strong>file: </strong>").concat(error.file, "</p>\n            <p><strong>line: </strong>").concat(error.line, "</p>\n        ");
    if (error.trace) {
      html += "<h5>Trace</h5>";
    } //end of if

    error.trace.forEach(function (item, index) {
      html += "\n                <div style=\"margin-bottom: 10px\">\n                    <p class=\"mb-0\"><strong>class: </strong> ".concat(item["class"], "</p>\n                    <p class=\"mb-0\"><strong>file: </strong>").concat(item.file, "</p>\n                    <p class=\"mb-0\"><strong>function: </strong>").concat(item["function"], "</p>\n                    <p class=\"mb-0\"><strong>line: </strong>").concat(item.line, "</p>\n                </div>\n            ");
    });
  } else {
    html += xhr.responseText;
  }
  $('#error-modal .modal-body').empty().append(html);
};
var handleAjaxErrors = function handleAjaxErrors(xhr, submitButtonHtml) {
  var errors = xhr['responseJSON']['errors'];
  for (var field in xhr['responseJSON']['errors']) {
    $(".ajax-form.active input[name=\"".concat(field, "\"], .ajax-form.active select[name=\"").concat(field, "\"], .ajax-form.active textarea[name=\"").concat(field, "\"]")).closest('.form-group').append("<span class=\"invalid-feedback d-block\">".concat(errors[field][0], "</span>"));
    $(".ajax-form.active input[data-error-name=\"".concat(field, "\"], .ajax-form.active select[data-error-name=\"").concat(field, "\"], .ajax-form.active textarea[data-error-name=\"").concat(field, "\"]")).closest('.form-group').append("<span class=\"invalid-feedback d-block\">".concat(errors[field][0], "</span>"));
  }
  if ($('.invalid-feedback.d-block').length) {
    $('html, body, .page-data').animate({
      scrollTop: $('.invalid-feedback.d-block').offset().top - 300
    }, 200);
  } //end of if

  $('.ajax-form input[type="password"]').val("");
  $('.ajax-form input.empty').val("");
};
var handleAjaxRedirects = function handleAjaxRedirects(response, submitButtonHtml) {
  if (response['success_message'] && response['redirect_to']) {
    new Noty({
      layout: 'topRight',
      text: response['success_message'],
      timeout: 2000,
      killer: true
    }).show();
    setTimeout(function () {
      window.location.href = response['redirect_to'];
    }, 100);
  } else if (response['redirect_to'] || response['success_message'] || response['replace'] || response['modal_view']) {
    if (response['redirect_to']) {
      Livewire.navigate(response['redirect_to']);

      // window.location.href = response['redirect_to'];
    }
    if (response['success_message']) {
      new Noty({
        layout: 'topRight',
        text: response['success_message'],
        timeout: 2000,
        killer: true
      }).show();
    }
    if (response['replace']) {
      $(response['replace']).html(response['replace_with']);
    } //end of if

    if (response['modal_view']) {
      if (response['modal-size-class']) {
        $('#ajax-modal .modal-dialog').removeAttr('class').attr('class', 'modal-dialog modal-dialog-centered ' + response['modal-size-class']);
      } //end of if

      $('#ajax-modal .modal-title').text(response['modal_title']);
      $('#ajax-modal .modal-body').empty().append(response['modal_view']);
      $('#ajax-modal').modal('show');
      $('.ajax-form.active button[type="submit"]').html(submitButtonHtml);
      $('.ajax-form.active button[type="submit"]').attr('disabled', false);
    } //end of if
  } else {
    $('.ajax-form.active button[type="submit"]').html(submitButtonHtml);
    $('.ajax-form.active button[type="submit"]').attr('disabled', false);
  }
};
var handleAjaxRemoveElements = function handleAjaxRemoveElements(response) {
  if (response['remove']) {
    $(response['remove']).remove();
  } //end of if
};
var disabledLinks = function disabledLinks() {
  $(document).on('click', 'a.disabled, .disabled a, span[disabled]', function (e) {
    e.preventDefault();
    return;
  });
};
var handleRefreshDatatable = function handleRefreshDatatable() {
  if ($('.datatable').length) {
    $('.datatable').DataTable().ajax.reload();
  } //end of if
};
window.initDatePicker = function () {
  $('.date-picker').flatpickr({
    dateFormat: 'Y-m-d',
    disableMobile: "true",
    locale: "ar",
    position: 'top right'
  });
  $('.date-range-picker').each(function () {
    var defaultFromDate = $(this).data('default-from-date');
    var defaultToDate = $(this).data('default-to-date');
    $(this).flatpickr({
      mode: "range",
      locale: "ar",
      position: 'top right',
      dateFormat: "Y-m-d",
      defaultDate: [defaultFromDate !== null && defaultFromDate !== void 0 ? defaultFromDate : '', defaultToDate !== null && defaultToDate !== void 0 ? defaultToDate : ''],
      onClose: function onClose(selectedDates, dateStr, instance) {
        var fromDate = [selectedDates[0].getFullYear(), selectedDates[0].getMonth() + 1, selectedDates[0].getDate()].join('-');
        var toDate = [selectedDates[1].getFullYear(), selectedDates[1].getMonth() + 1, selectedDates[1].getDate()].join('-');
        $('#from-date').val(fromDate).trigger('change');
        $('#to-date').val(toDate).trigger('change');

        // $('.datatable').DataTable().ajax.reload();
      }
    });
  });
  $('.time-picker').each(function () {
    $(this).flatpickr({
      enableTime: true,
      noCalendar: true,
      time_24hr: false,
      locale: "ar",
      position: 'top right'
    });
  });
  $('.date-time-picker').each(function () {
    $(this).flatpickr({
      enableTime: true,
      dateFormat: "Y-m-d H:i K",
      locale: "ar",
      position: 'top right'
    });
  });

  // $(".hijri-date-picker").hijriDatePicker({
  //     locale: "ar-sa",
  //     format: "YYYY-MM-DD",
  //     hijriFormat: "iYYYY-iMM-iDD",
  //     dayViewHeaderFormat: "MMMM YYYY",
  //     hijriDayViewHeaderFormat: "iMMMM iYYYY",
  //     showSwitcher: true,
  //     allowInputToggle: true,
  //     useCurrent: true,
  //     isRTL: true,
  //     viewMode: 'days',
  //     keepOpen: true,
  //     hijri: false,
  //     debug: true,
  //     // showClear: true,
  //     showTodayButton: true,
  //     minDate: new Date(),
  //     // showClose: true,
  //
  // });
};
var initGalleryImages = function initGalleryImages() {
  $('.gallery-images').each(function () {
    // the containers for all your galleries

    $(this).magnificPopup({
      delegate: 'a',
      // child items selector, by clicking on it popup will open
      type: 'image',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
      }
    });
  });
};
var dataTableRecordSelect = function dataTableRecordSelect() {
  //select all functionality
  $(document).on('change', '.record__select', function () {
    getSelectedRecords();
  });

  // used to select all records
  $(document).on('change', '#record__select-all', function () {
    $('.record__select').prop('checked', this.checked);
    getSelectedRecords();
  });
  var getSelectedRecords = function getSelectedRecords() {
    var recordIds = [];
    $.each($(".record__select:checked"), function () {
      recordIds.push($(this).val());
    });
    $('#record-ids').val(JSON.stringify(recordIds));
    recordIds.length > 0 ? $('#bulk-delete').attr('disabled', false) : $('#bulk-delete').attr('disabled', true);
  };
};
var showImageUnderFileExplorer = function showImageUnderFileExplorer() {
  $(document).on('change', '.load-image', function (e) {
    var that = $(this);
    var reader = new FileReader();
    reader.onload = function () {
      that.parent().find('.loaded-image').attr('src', reader.result);
      that.parent().find('.loaded-image').css('display', 'block');
    };
    reader.readAsDataURL(e.target.files[0]);
  });
};
var toggleActive = function toggleActive() {
  $(document).on('change', '.toggle-active', function () {
    var url = $(this).data('url');
    $.ajax({
      url: url,
      method: 'PUT',
      cache: false,
      success: function success(data) {
        new Noty({
          type: 'warning',
          layout: 'topRight',
          text: data.message,
          timeout: 2000,
          killer: true
        }).show();
      }
    }); //end of ajax call
  });
};

// let checkFieldLanguage = () => {
//
//     $(document).on("input", 'input[type="text"]', function () {
//
//         var ranges = [ // EMOJIS RANGE
//             '[\u2700-\u27BF]',
//             '[\uE000-\uF8FF]',
//             '\uD83C[\uDC00-\uDFFF]',
//             '\uD83D[\uDC00-\uDFFF]',
//             '[\u2011-\u26FF]',
//             '\uD83E[\uDD10-\uDDFF]'
//         ];
//
//         let str = $(this).val();
//
//         str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
//
//         if (str == null || str.trim() == '') {
//             str = str.trim()
//         }
//
//         $(this).val(str);
//
//     });
//
//     $(document).on('keyup', '.select2-search__field', function () {
//
//         let str = $(this).val();
//
//         str = str.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, "").trim();
//         // str = str.replace(/[^\u0600-\u06FF_ , a-z , A-Z , 0-9]+$/g, "");
//         $(this).val(str);
//
//     });
//
//     $(document).on(
//         'input[name="first_name"], ' +
//         'input[name="last_name"], ',
//         function () {
//
//             let regex = /[!@#$%^&*()_+\-={}[\]\\|:;"'<>,.?\,0-9]/g; //prevent this regex
//             let str = $(this).val();
//             str = str.replace(regex, "");
//
//             if (str.isEmpty || str === " ") {
//                 str = str.trim();
//             }//end of if
//
//             $(this).val(str);
//         });
//
//     $(document).on(
//         "input",
//         'input[data-error-name="ar.title"], ' +
//         'input[data-error-name="ar.subtitle"], ' +
//         'input[data-error-name="ar.name"], ' +
//         'textarea[data-error-name="ar.description"], ' +
//         'textarea[data-error-name="ar.short_description"], ' +
//         'input[data-error-name="ar.address"]',
//         function () {
//
//             let regex = /[a-z,A-Z]/g; //prevent this regex
//             let str = $(this).val();
//             str = str.replace(regex, "");
//
//             if (str.isEmpty || str === " ") {
//                 str = str.trim();
//             }//end of if
//
//             $(this).val(str);
//
//         }
//     );
//
//     $(document).on(
//         "input",
//         'input[data-error-name="en.title"], ' +
//         'input[data-error-name="en.subtitle"], ' +
//         'input[data-error-name="en.name"],' +
//         'textarea[data-error-name="en.description"], ' +
//         'textarea[data-error-name="en.short_description"], ' +
//         'input[data-error-name="en.address"]',
//         function () {
//
//             let regex = /[\u0600-\u06FF_]/g; //prevent this regex
//             let str = $(this).val();
//             str = str.replace(regex, "");
//
//             if (str.isEmpty || str === " ") {
//                 str = str.trim();
//             }//end of if
//
//             $(this).val(str);
//
//         }
//     );
//
// }
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!************************************************!*\
  !*** ./public/admin_assets/custom/js/index.js ***!
  \************************************************/
$(function () {
  renderOrdersChart();
  renderOrdersChartByYear();
}); //end of document ready

var renderOrdersChart = function renderOrdersChart() {
  var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  if ($('#orders-chart-wrapper').length) {
    var loadingHtml = "\n              <div style=\"height: 400px;\" class=\"d-flex justify-content-center align-items-center\">\n                  <div class=\"loader-md\"></div>\n              </div>\n        ";
    $('#orders-chart-wrapper').empty().append(loadingHtml);
    var url = $('#orders-chart-wrapper').data('url');
    $.ajax({
      url: url,
      data: data,
      success: function success(html) {
        $('#orders-chart-wrapper').empty().append(html);
      }
    }); //end of ajax call
  } //end of if
};
var renderOrdersChartByYear = function renderOrdersChartByYear() {
  $('#orders-chart-year').on('change', function () {
    renderOrdersChart({
      year: this.value
    });
  });
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!************************************************!*\
  !*** ./public/admin_assets/custom/js/roles.js ***!
  \************************************************/
$(function () {
  $(document).on('change', '.all-permissions', function () {
    $(this).parents('tr').find('input[type="checkbox"]').prop('checked', this.checked);
  });
  $(document).on('change', '.role', function () {
    if (!this.checked) {
      $(this).parents('tr').find('.all-permissions').prop('checked', this.checked);
    }
  });
}); //end of document ready
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!****************************************************!*\
  !*** ./public/admin_assets/custom/js/languages.js ***!
  \****************************************************/
$(function () {
  toggleActive();
}); //end of document ready

var toggleActive = function toggleActive() {
  $(document).on('change', '.language-toggle-active', function (e) {
    e.preventDefault();
    $(this).parent().find('form').submit();
  });
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!****************************************************!*\
  !*** ./public/admin_assets/custom/js/countries.js ***!
  \****************************************************/
$(function () {
  fetchGovernorates();
  fetchAreas();
}); //end of document ready

var fetchGovernorates = function fetchGovernorates() {
  $(document).on('change', '#country-id', function () {
    if (this.value && this.value != 0) {
      var url = $(this).find(':selected').data('governorates-url');
      var emptyValueText = $('#governorate-id').find(':selected').text();
      $.ajax({
        url: url,
        data: {
          'empty_value_text': emptyValueText
        },
        cache: false,
        success: function success(html) {
          $('#governorate-id option').not(':first').remove();
          $('#governorate-id').append(html);
          $('#governorate-id').attr('disabled', false);
        }
      }); //end of ajax call
    } else {
      $('#governorate-id').attr('disabled', true);
      $('#governorate-id').val('').trigger('change');
      $('#area-id').attr('disabled', true);
      $('#area-id').val('').trigger('change');
    } //end of else
  });
};
var fetchAreas = function fetchAreas() {
  $(document).on('change', '#governorate-id', function () {
    if (this.value && this.value != 0) {
      var url = $(this).find(':selected').data('areas-url');
      $.ajax({
        url: url,
        cache: false,
        success: function success(html) {
          $('#area-id option').not(':first').remove();
          $('#area-id').append(html);
          $('#area-id').attr('disabled', false);
        }
      }); //end of ajax call
    } else {
      $('#area-id').attr('disabled', true);
      $('#area-id').val('').trigger('change');
    } //end of else
  });
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***************************************************!*\
  !*** ./public/admin_assets/custom/js/teachers.js ***!
  \***************************************************/
$(function () {
  handleTeacherSection();
  handleCenterManager();
}); //end of document ready

var handleTeacherSection = function handleTeacherSection() {
  $(document).on('click', '.teacher-center', function () {
    sections = $(this).closest('.row').find('.teacher-sections');
    if ($(this).is(':checked')) {
      sections.attr('disabled', false).attr('required', true);
    } else {
      sections.attr('disabled', true).attr('required', false);
      sections.val(0).trigger('change');
    }
    window.initSelect2();
  });
};
var handleCenterManager = function handleCenterManager() {
  $(document).on('change', '#is-center-manager', function () {
    if ($(this).is(':checked')) {
      $('#center-ids-as-manager').attr('disabled', false).attr('required', true);
    } else {
      $('#center-ids-as-manager').attr('disabled', true).attr('required', false);
      $('#center-ids-as-manager').val(0).trigger('change');
    }
    window.initSelect2();
  });
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**************************************************!*\
  !*** ./public/admin_assets/custom/js/centers.js ***!
  \**************************************************/
$(function () {
  fetchProjects();
  fetchSections();
}); //end of document ready

var fetchProjects = function fetchProjects() {
  $(document).on('change', '#center-id', function () {
    if (this.value && this.value != 0) {
      var url = $(this).find(':selected').data('projects-url');
      $.ajax({
        url: url,
        cache: false,
        success: function success(html) {
          $('#project-id option').not(':first').remove();
          $('#project-id').append(html);
          $('#project-id').attr('disabled', false);
          $('#section-id').attr('disabled', true);
          $('#section-id').val('').trigger('change');
        }
      }); //end of ajax call
    } else {
      $('#project-id').attr('disabled', true);
      $('#project-id').val('').trigger('change');
      $('#section-id').attr('disabled', true);
      $('#section-id').val('').trigger('change');
    } //end of else
  });
};
var fetchSections = function fetchSections() {
  $(document).on('change', '#project-id', function () {
    if (this.value && this.value != 0) {
      var url = $(this).find(':selected').data('sections-url');
      $.ajax({
        url: url,
        cache: false,
        success: function success(html) {
          $('#section-id option').not(':first').remove();
          $('#section-id').append(html);
          $('#section-id').attr('disabled', false);
        }
      }); //end of ajax call
    } else {
      $('#section-id').attr('disabled', true);
      $('#section-id').val('').trigger('change');
    } //end of else
  });
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***************************************************!*\
  !*** ./public/admin_assets/custom/js/lectures.js ***!
  \***************************************************/
$(function () {
  addMorePages();
  deletePage();
  handleAttendanceStatus();
}); //end of document ready

var addMorePages = function addMorePages() {
  $(document).on('click', '#add-more-pages-btn', function (e) {
    e.preventDefault();
    $('#pages-row-wrapper select.select2').select2('destroy');
    $('#pages-row-wrapper').append($('.page-row:first').clone());
    $('#pages-row-wrapper .page-row:last input').val('');
    $('#pages-row-wrapper .page-row:last select').val('').trigger('change');
    $('#pages-row-wrapper .page-row:last input[name="pages[0][from]"]').attr('name', 'pages[' + ($('.page-row').length - 1) + '][from]');
    $('#pages-row-wrapper .page-row:last input[name="pages[0][to]"]').attr('name', 'pages[' + ($('.page-row').length - 1) + '][to]');
    $('#pages-row-wrapper .page-row:last select[name="pages[0][assessment]"]').attr('name', 'pages[' + ($('.page-row').length - 1) + '][assessment]');
    window.initSelect2();
    toggleDisabledDeletePageBtn();
  });
};
var deletePage = function deletePage() {
  $(document).on('click', '.delete-page-btn', function (e) {
    e.preventDefault();
    $(this).closest('.page-row').remove();
    toggleDisabledDeletePageBtn();
  });
};
var toggleDisabledDeletePageBtn = function toggleDisabledDeletePageBtn() {
  if ($('.delete-page-btn').length > 1) {
    $('.delete-page-btn').attr('disabled', false);
  } else {
    $('.delete-page-btn').attr('disabled', true);
  }
};
var handleAttendanceStatus = function handleAttendanceStatus() {
  $(document).on('change', '#attendance-status', function (e) {
    if ($(this).val() && $(this).val() == 'attended') {
      $('#pages-wrapper').show();
      $('#pages-wrapper input, #pages-wrapper select').attr('required', true).attr('disabled', false);
    } else {
      $('#pages-wrapper').hide();
      $('#pages-wrapper input, #pages-wrapper select').val('').attr('required', false).attr('disabled', true);
    }
  });
};
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***************************************************!*\
  !*** ./public/admin_assets/custom/js/sections.js ***!
  \***************************************************/
$(function () {
  fetchLectureTypes();
}); //end of document ready

var fetchLectureTypes = function fetchLectureTypes() {
  $(document).on('change', '#section-id', function () {
    if ($(this).val() && $(this).val() != 0) {
      var url = $(this).find(':selected').data('lecture-types-url');
      $.ajax({
        url: url,
        cache: false,
        success: function success(html) {
          $('#lecture-type option').not(':first').remove();
          $('#lecture-type').append(html);
          $('#lecture-type').attr('disabled', false);
        }
      }); //end of ajax call
    } else {
      $('#lecture-type').attr('disabled', true);
      $('#lecture-type').val('').trigger('change');
    }
  });
};
})();

/******/ })()
;
