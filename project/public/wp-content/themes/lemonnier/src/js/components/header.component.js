export class Header {
  _constructor() {}

  prevX = 0;

  init() {
    console.log("init header JS class OK");
    this.listenScroll();
    this.listenBurger();
  }

  listenScroll() {
    document.addEventListener("scroll", () => {
      this.headerBehavior();
    });
  }

  headerBehavior() {
    const posy = window.scrollY;
    const limit = document.querySelector("#header").clientHeight;

    console.log("limit : ", limit);

    console.log(this.prevX < posy, this.prevX, posy);
    /// if down
    if (this.prevX < posy || posy == 0) {
      if (posy > limit) {
        document.querySelector("body").classList.add("scrolled");
        document.querySelector("body").classList.remove("scrolled-up");
      } else if (posy == 0) {
        document.querySelector("body").classList.remove("scrolled");
        document.querySelector("body").classList.remove("scrolled-up");
      }

      this.prevX = posy;
    } else if (this.prevX > posy) {
      console.log("on remonte", this.prevX - posy);

      if (this.prevX - posy > 1000 && posy > limit) {
        document.querySelector("body").classList.remove("scrolled");
        document.querySelector("body").classList.add("scrolled-up");

        this.prevX = posy;
      } else if (posy < limit) {
        document.querySelector("body").classList.add("scrolled");
        document.querySelector("body").classList.remove("scrolled-up");
        this.prevX = posy;
      }
    }
  }
  listenBurger() {
    document.querySelector(".burger").addEventListener("click", () => {
      document.querySelector("#header").classList.toggle("menu-open");
      document.querySelector("body").classList.toggle("menu-open");
    });
  }

  test() {
    console.log("test");
  }
}
