/*
 * Slinky
 * Rather sweet menus
 * @author Ali Zahid <ali.zahid@live.com>
 * @license MIT
 */

class Slinky {
  // default options
  get options() {
    return {
      resize: true,
      speed: 300,
      theme: 'slinky-theme-default',
      title: false
    };
  }

  constructor(element, options = {}) {
    // save settings
    this.settings = {
      ...this.options,
      ...options
    };

    // let's go!
    this._init(element);
  }

  // setup the DOM just for us
  _init(element) {
    // the two elements of water and moisture
    this.menu = typeof element === "string" ? document.querySelector(element) : element;
    this.base = this.menu.children[0];

    const { menu, settings } = this;

    // set theme
    menu.classList.add('slinky-menu', settings.theme);

    // set transition speed
    this._transition(settings.speed);

    // add arrows to links with children
    Array.from(menu.querySelectorAll('a + ul')).forEach(ul => {
      ul.previousElementSibling.classList.add('next');
    });

    // wrap link text with <span>
    // mostly for styling
    Array.from(menu.querySelectorAll('li > a')).forEach(a => {
      const span = document.createElement('span');
      span.innerHTML = a.innerHTML;
      a.innerHTML = '';
      a.appendChild(span);
    });

    // create header item
    const header = document.createElement('li');
    header.classList.add('header');

    // prepend it to the list
    Array.from(menu.querySelectorAll('li > ul')).forEach(ul => ul.prepend(header.cloneNode(true)));

    // create back buttons
    const back = document.createElement('a');
    back.href = '#';
    back.classList.add('back');

    // prepend them to the headers
    Array.from(menu.querySelectorAll('.header')).forEach(header => header.prepend(back.cloneNode(true)));

    // do we need to add titles?
    if (settings.title) {
      Array.from(menu.querySelectorAll('li > ul')).forEach(ul => {
        const label = ul.parentElement.querySelector('a').textContent;

        if (label) {
          const title = document.createElement('header');
          title.classList.add('title');
          title.textContent = label;

          ul.querySelector('.header').appendChild(title);
        }
      });
    }

    // add click listeners
    this._addListeners();

    // jump to initial active
    this._jumpToInitial();
  }

  // click listeners
  _addListeners() {
    const { menu, settings } = this;

    menu.addEventListener('click', e => {
      const link = e.target.closest('a');
      if (!link) return;

      // prevent broken/half transitions
      if (this._clicked + settings.speed > Date.now()) {
        e.preventDefault();
        return false;
      }

      // cache click time to check on next click
      this._clicked = Date.now();

      // prevent default if it's a hash or a Slinky button
      if (
        link.getAttribute('href').startsWith('#') ||
        link.classList.contains('next') ||
        link.classList.contains('back')
      ) {
        e.preventDefault();
      }

      // time to move
      if (link.classList.contains('next')) {
        menu.querySelector('.active')?.classList.remove('active');

        const nextUl = link.nextElementSibling;
        nextUl.style.display = 'block';
        nextUl.classList.add('active');

        this._move(1);

        if (settings.resize) {
          this._resize(nextUl);
        }
      } else if (link.classList.contains('back')) {
        this._move(-1, () => {
          menu.querySelector('.active')?.classList.remove('active');

          const parentUl = link.closest('ul').parentElement.closest('ul');
          link.closest('ul').style.display = 'none';
          parentUl.classList.add('active');
        });

        if (settings.resize) {
          const parentUl = link.closest('ul').parentElement.closest('ul');
          this._resize(parentUl);
        }
      }
    });
  }

  // jump to initial active on init
  _jumpToInitial() {
    const { menu, settings } = this;

    const active = menu.querySelector('.active');

    if (active) {
      active.classList.remove('active');
      this.jump(active, false);
    }

    setTimeout(() => menu.style.height = `${menu.offsetHeight}px`, settings.speed);
  }

  // slide the menu
  _move(depth = 0, callback = () => {}) {
    if (depth === 0) return;

    const { settings, base } = this;

    const left = parseInt(base.style.left) || 0;

    base.style.left = `${left - depth * 100}%`;

    if (typeof callback === 'function') {
      setTimeout(callback, settings.speed);
    }
  }

  // resize the menu
  _resize(content) {
    this.menu.style.height = `${content.offsetHeight}px`;
  }

  // set the transition speed
  _transition(speed = 300) {
    this.menu.style.transitionDuration = `${speed}ms`;
    this.base.style.transitionDuration = `${speed}ms`;
  }

  // jump to an element
  jump(target, animate = true) {
    if (!target) return;

    const { menu, settings } = this;

    const to = typeof target === "string" ? menu.querySelector(target) : target;

    const active = menu.querySelector('.active');

    let count = 0;

    if (active) {
      count = Array.from(active.closest('ul').querySelectorAll('ul')).length;
    }

    menu.querySelectorAll('ul').forEach(ul => {
      ul.classList.remove('active');
      ul.style.display = 'none';
    });

    const parents = Array.from(to.closest('ul').querySelectorAll('ul'));
    parents.forEach(parent => parent.style.display = 'block');

    to.style.display = 'block';
    to.classList.add('active');

    if (!animate) this._transition(0);

    this._move(parents.length - count);

    if (settings.resize) this._resize(to);

    if (!animate) this._transition(settings.speed);
  }

  home(animate = true) {
    const { base, menu, settings } = this;

    if (!animate) this._transition(0);

    const active = menu.querySelector('.active');
    const parents = Array.from(active.closest('ul').querySelectorAll('ul'));

    this._move(-parents.length, () => {
      active.classList.remove('active');
      active.style.display = 'none';
      parents.forEach(parent => {
        if (parent !== base) parent.style.display = 'none';
      });
    });

    if (settings.resize) this._resize(base);

    if (!animate) this._transition(settings.speed);
  }

  destroy() {
    const { base, menu } = this;

    menu.querySelectorAll('.header').forEach(header => header.remove());
    menu.querySelectorAll('a').forEach(a => {
      a.classList.remove('next');
      a.removeEventListener('click');
    });

    menu.style.height = '';
    menu.style.transitionDuration = '';

    base.style.left = '';
    base.style.transitionDuration = '';

    menu.querySelectorAll('li > a > span').forEach(span => {
      span.outerHTML = span.innerHTML;
    });

    menu.querySelector('.active')?.classList.remove('active');

    const styles = menu.className.split(' ');
    styles.forEach(style => {
      if (style.startsWith('slinky')) menu.classList.remove(style);
    });

    ['settings', 'menu', 'base'].forEach(field => delete this[field]);
  }
}









         




