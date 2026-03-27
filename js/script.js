const menuToggle = document.getElementById("menuToggle");
const nav = document.getElementById("nav");
const contactForm = document.getElementById("contactForm");
const formMessage = document.getElementById("formMessage");

menuToggle.addEventListener("click", () => {
  nav.classList.toggle("active");
});

document.querySelectorAll(".nav a").forEach((link) => {
  link.addEventListener("click", () => {
    nav.classList.remove("active");
  });
});

contactForm.addEventListener("submit", function (e) {
  e.preventDefault();
  formMessage.textContent = "Your message has been sent successfully!";
  contactForm.reset();

  setTimeout(() => {
    formMessage.textContent = "";
  }, 3000);
});

const aboutTabs = document.querySelectorAll(".tag");
const aboutMainImage = document.getElementById("aboutMainImage");
const aboutHeading = document.getElementById("aboutHeading");
const aboutParagraph = document.getElementById("aboutParagraph");

const aboutData = {
  mission: {
    image: "images/about-mission.png",
    alt: "Our Mission",
    heading: "Inspiring Responsible Waste Management",
    paragraph:
      "Our mission is to encourage responsible waste disposal by providing an accessible platform that educates users about recycling practices and proper waste handling. By empowering individuals with knowledge and simple tools, we help communities take meaningful steps toward protecting the environment."
  },
  vision: {
    image: "images/about-vision.png",
    alt: "Our Vision",
    heading: "A Cleaner Planet for Future Generations",
    paragraph:
      "Our vision is to create a world where communities actively participate in sustainable waste management. We aim to inspire environmentally responsible behavior that supports cleaner cities, healthier ecosystems, and a better future for generations to come."
  },
  goal: {
    image: "images/about-goal.png",
    alt: "Our Goal",
    heading: "Making Waste Management Simple and Smart",
    paragraph:
      "Our goal is to simplify the process of managing waste by providing clear information about waste categories and efficient collection systems. Through technology and awareness, we strive to reduce landfill waste and encourage recycling practices."
  },
  history: {
    image: "images/about-history.png",
    alt: "Our History",
    heading: "Building Greener Communities Step by Step",
    paragraph:
      "Our journey began with a simple idea: make waste management easier, smarter, and more accessible for everyone. Over time, we have continued developing community-focused solutions that support cleaner living and long-term environmental responsibility."
  }
};

aboutTabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    aboutTabs.forEach((btn) => btn.classList.remove("active"));
    tab.classList.add("active");

    const selectedTab = tab.getAttribute("data-tab");
    const content = aboutData[selectedTab];

    aboutMainImage.classList.add("about-fade");
    aboutHeading.classList.add("about-fade");
    aboutParagraph.classList.add("about-fade");

    setTimeout(() => {
      aboutMainImage.src = content.image;
      aboutMainImage.alt = content.alt;
      aboutHeading.textContent = content.heading;
      aboutParagraph.textContent = content.paragraph;

      aboutMainImage.classList.remove("about-fade");
      aboutHeading.classList.remove("about-fade");
      aboutParagraph.classList.remove("about-fade");
    }, 200);
  });
});

const loaderAnimation = lottie.loadAnimation({
  container: document.getElementById("lottie-loader"),
  renderer: "svg",
  loop: true,
  autoplay: true,
  path: "assets/loading.json"
});

window.addEventListener("load", () => {
  const preloader = document.getElementById("preloader");

  setTimeout(() => {
    preloader.classList.add("hide");
  }, 1800);
});