<style>
  .footer-5-column {
    background-color: #dddddd;
    padding-top: 3rem;
    margin-top: 2rem;
  }

  .footer-5-column p {
    color: #777777;
  }

  .footer-5-column .footer-container {
    max-width: 90%;
    width: 100%;
    margin-right: auto;
    margin-left: auto;
    padding-left: 12px;
    padding-right: 12px;
    box-sizing: border-box;
  }

  .footer-5-column .footer-container .footer-navbar-container {
    display: flex;
    align-items: flex-start;
    flex-wrap: wrap;
    margin-bottom: 3rem;
    margin-right: auto;
    margin-left: auto;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details {
    width: 35%;
    max-width: 100%;
    flex: 0 0 auto;
    padding-right: 2rem;
    line-height: 1.428;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-logo {
    width: 60px;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-logo img {
    max-width: 100%;
    height: auto;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-logo svg {
    width: 100%;
    height: auto;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-content {
    margin-top: 1rem;
    font-size: 16px;
    line-height: 1.8;
    padding-right: 1rem;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-icons {
    margin-top: 1.5rem;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-icons ul {
    display: flex;
    padding: 0;
    margin: 0;
    list-style-type: none;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-icons ul li {
    list-style: none;
    display: flex;
    flex-direction: row;
    margin-right: 14px;
  }

  .footer-5-column .footer-container .footer-navbar-container .footer-company-details .footer-icons ul li a {
    width: 30px;
    padding: 6px;
  }

  .footer-5-column .footer-navbar {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    align-items: flex-start;
    flex-grow: 1;
    line-height: 1.428;
  }

  .footer-5-column .footer-navbar>.footer-navbar-col {
    width: 25%;
    flex: 0 0 auto;
  }

  .footer-5-column .footer-navbar .footer-navbar-col h5 {
    margin-bottom: 1.5rem;
    color: #000;
    overflow-wrap: break-word;
    padding: 0 0.5rem 0 0;
  }

  .footer-5-column .footer-navbar .footer-navbar-col ul {
    padding: 0 0.5rem 0 0;
    margin: 0;
  }

  .footer-5-column .footer-navbar .footer-navbar-col ul li {
    list-style: none;
  }

  .footer-5-column .footer-navbar .footer-navbar-col ul li:not(:last-child) {
    margin-bottom: 1rem;
  }

  .footer-5-column .footer-navbar .footer-navbar-col ul li a {
    font-size: 16px;
    text-decoration: none;
    color: #777777;
    overflow-wrap: break-word;
  }

  .footer-5-column .footer-navbar .footer-navbar-col ul li a:hover {
    color: #000;
  }

  .footer-5-column .footer-copyright {
    padding: 2rem 0;
    border-top: 1px solid rgb(219, 215, 215);
  }

  .footer-5-column .footer-copyright p {
    font-size: 14px;
    margin-bottom: 0;
  }

  @media all and (max-width: 1140px) {

    .footer-5-column .footer-container .footer-navbar-container,
    .footer-5-column .footer-navbar {
      row-gap: 3rem;
    }

    .footer-5-column .footer-container .footer-navbar-container .footer-company-details,
    .footer-5-column .footer-container .footer-navbar-container .footer-navbar {
      padding: 0;
      width: 100%;
    }
  }

  @media all and (max-width: 992px) {
    .footer-5-column .footer-navbar .footer-navbar-col {
      width: 50%;
    }
  }

  @media all and (max-width: 576px) {
    .footer-5-column .footer-navbar .footer-navbar-col {
      width: 100%;
    }
  }

  .footer-5-column {
    padding-top: 3rem;
    margin-top: 2rem;

    p {
      color: #777777;
    }

    .footer-container {
      max-width: 1320px;
      width: 100%;
      margin-right: auto;
      margin-left: auto;
      padding-left: 12px;
      padding-right: 12px;
      box-sizing: border-box;

      .footer-navbar-container {
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        margin-bottom: 3rem;
        margin-right: auto;
        margin-left: auto;

        .footer-company-details {
          width: 35%;
          max-width: 100%;
          flex: 0 0 auto;
          padding-right: 2rem;
          line-height: 1.428;

          .footer-logo {
            width: 60px;

            img {
              max-width: 100%;
              height: auto;
            }

            svg {
              width: 100%;
              height: auto;
            }
          }

          .footer-content {
            margin-top: 1rem;
            font-size: 16px;
            line-height: 1.8;
            padding-right: 1rem;
          }

          .footer-icons {
            margin-top: 1.5rem;

            ul {
              display: flex;
              padding: 0;
              margin: 0;
              list-style-type: none;

              li {
                list-style: none;
                display: flex;
                flex-direction: row;
                margin-right: 14px;

                a {
                  width: 30px;
                  padding: 6px;
                }
              }
            }
          }
        }
      }
    }

    .footer-navbar {
      display: flex;
      flex-wrap: wrap;
      flex-direction: row;
      align-items: flex-start;
      flex-grow: 1;
      line-height: 1.428;
      gap: 2rem;

      >.footer-navbar-col {
        width: 40%;
        flex: 0 0 auto;
      }

      .footer-navbar-col {
        h5 {
          margin-bottom: 1rem;
          color: #000;
          overflow-wrap: break-word;
          padding: 0 0.5rem 0 0;
        }

        ul {
          padding: 0 0.5rem 0 0;
          margin: 0;

          li {
            list-style: none;

            &:not(:last-child) {
              margin-bottom: 1rem;
            }

            a {
              font-size: 16px;
              text-decoration: none;
              color: #777777;
              overflow-wrap: break-word;

              &:hover {
                color: #000;
              }
            }
          }
        }
      }
    }

    .footer-copyright {
      padding: 2rem 0;
      border-top: 1px solid rgb(219, 215, 215);

      p {
        font-size: 14px;
        margin-bottom: 0;
      }
    }
  }

  @media all and (max-width: 1140px) {
    .footer-5-column {
      .footer-container {
        .footer-navbar-container {
          row-gap: 3rem;

          .footer-company-details {
            padding: 0;
            width: 100%;
          }

          .footer-navbar {
            padding: 2rem 0;
            width: 100%;
          }
        }
      }

      .footer-navbar {
        row-gap: 3rem;
      }
    }
  }

  @media all and (max-width: 992px) {
    .footer-5-column {
      .footer-navbar {
        .footer-navbar-col {
          width: 50%;
        }
      }
    }
  }

  /* Newsletter Section  */
  .newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .newsletter-input {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
  }

  .newsletter-btn {
    padding: 0.5rem 1rem;
    background-color: rgb(1, 1, 1);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
  }

  .newsletter-btn:hover {
    background-color: #333;
  }
</style>

<div class="footer-5-column">
  <div class="footer-container">
    <div class="footer-navbar-container" style="margin-top: 0.1rem; padding-top: 0.1rem;">
      <div class="footer-company-details">
        <div class="footer-logo">
          <a href="index.php" class="logo-link">
            <img src="Images/logo.png" class="logo-img" />
          </a>
        </div>
        <div class="footer-content">
          <p>
            Health and Wellness are the most important things in life. We are here to help you achieve your goals and live a healthy life.
            <br />We provide the best services to help you achieve your goals. We are here to help you achieve your goals and live a healthy life.
          </p>
        </div>
        <div class="footer-icons">
          <ul>
            <li>
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
                    d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
                    d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path
                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path
                    d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z" />
                </svg>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="footer-navbar" style="padding-left: 4rem;">
        <div class="footer-navbar-col">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="index.php"> Home </a></li>
            <li><a href="about.php"> About Us </a></li>
            <li><a href="blogs.php"> Blog </a></li>
            <li><a href="categories.php"> Categories </a></li>
            <li><a href="contact.php"> Contact us </a></li>
          </ul>
        </div>
        <div class="footer-navbar-col">
          <h3>Categories</h3>
          <ul>
            <li><a href="blogs.php?category=3"> Fitness </a></li>
            <li><a href="blogs.php?category=1"> Mental Wellness </a></li>
            <li><a href="blogs.php?category=2"> Nutrition </a></li>
            <li><a href="blogs.php?category=4"> Sleep </a></li>
            <li><a href="blogs.php?category=9"> Preventive Care </a></li>
          </ul>
        </div>
      </div>
    </div>

    <hr>

    <div class="footer-copyright" style="padding-top: 0.1rem;">
      <p style="text-align: center;">2025 © Health and Wellness - Made by 12, 17, 23</p>
    </div>
  </div>
</div>