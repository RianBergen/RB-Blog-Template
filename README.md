# RB Blog Template
A Simple To Use Template For Blog Style Websites!  
My Website Uses This Template: https://www.rianbergen.com/



#### Site Dependencies
1. This site requires that you have a webserver capable of running at least:
   1. HTML 5, CSS 3, JS 5, PHP 7.3, MYSQL 5.5.60
1. We use TinyMCE for any Edit Fields within the Admin Panel. You will need an API Key which you can get here:
   1. https://www.tiny.cloud/
1. We use Disqus for any comments/discussions on the site. You can get a Short Code here:
   1. https://disqus.com/



#### How To Install
1. Download the latest Source Code, or, download the latest stable release from GitHub.
1. Copy and Paste all of the Source Files into your Website wwwroot folder. If done correctly, the `.htaccess` file will end up in the wwwroot folder.
1. Open up the `.htaccess` file and change all of the following:
   1. Change every instance of `YOURDOMAIN` with your domain name. Example: My domain name is rianbergen, so, I will change `YOURDOMAIN` with `rianbergen`.
   1. If you do not have an `https` certificate, replace every instance of `https` with `http`. If you do have an https certificate, please ignore this step.
   1. If you do not have `.com` as your top-level domain, replace every instance of `.com` with your top-level domain. Examples: `.net`, `.org`, `.gov`, etc.
1. Open up the `404.html` and `500.html` files and change all of the following:
   1. Change every instance of `YOURDOMAIN` with your domain name. Example: My domain name is rianbergen, so, I will change `YOURDOMAIN` with `rianbergen`. There is one instance of `YOURDOMAIN` in the html title. I changed that to `Rian Bergen` instead.
   1. If you do not have an `https` certificate, replace every instance of `https` with `http`. If you do have an https certificate, please ignore this step.
   1. If you do not have `.com` as your top-level domain, replace every instance of `.com` with your top-level domain. Examples: `.net`, `.org`, `.gov`, etc.
1. Download the latest binaries folder from the latest stable release on GitHub. This will contain a SQL Database File that needs to be imported to your website.
1. Navigate to the following folder `\wwwroot \includes\credentials\` and open up the `credentials.php` file. This file contains all of the global site variables including your SQL Database Credentials (for #4 above) as well as the site dependency credentials. It should be pretty self-explanatory, though I will expand this section to answer any questions that may come up.
1. To install your own images, please go to the following folder `\wwwroot \_res\images\` and follow the instructions below.
   1. There are 3 logos within this folder. Please replace those with your own. They should be the exact same sizes and should be named exactly the same. These images appear in the title bar of your browser.
   1. To replace the About Picture, open up the `about` folder and replace the image in there with an image that is exactly the same size and has the same name.
   1. To replace the little images that appear next to recent posts in the sidebar, open up the `side` folder. In there, you should see 5 images with the names 1-5. These images correspond to the 5 images next to the posts listed in recent posts from top to bottom. Replace these with ones that have the same names and sizes.
      1. There are 5 more images within that folder (1-Number – 5-Number). These are old images I used to use. If you would like to use these instead of your own, rename them to 1-5 to replace the current RB Logos.



#### How To Use
1. If the installation went correctly, you should see a Under Maintenance Post on your homepage.
1. Going to www.YOUDOMAIN.com/admin (please replace YOURDOMAIN with your actual domain), will bring you to the Admin Panel Login.
   1. Username: Admin
   1. Password: Admin
1. Once Logged In, I recommend that you immediately go to `Users`.
   1. Click the `Edit` Action for the Admin User.
   1. Change the `Username`, `Password`, and `Email` to make sure that your Admin Panel is secure. Make sure to choose a strong password that you can easily remember. Click `Update User` once you are done.
1. After this, I recommend clicking `Pages`. Here you will find all of the Website Specific Pages and the Content that shows up on those pages. I recommend going through each one of them by clicking `Edit` and modifying the content to your liking.



#### How To Contribute
1. When posting issues:
   1. Please describe the issue/feature request as best as possible including steps to reproduce. Please also include code samples if possible
   1. Please use the appropriate labels for your issue.
      1. If it is a bug, use `Bug`.
      1. If you think it is a bug but aren’t sure, please use` Possible Bug`.
      1. If it is a question, please use `Question`.
      1. If it is a possible improvement to an existing feature, please use `Improvement`.
      1. For new feature requests, please use `Feature`.
1. Committing Code:
   1. Please Fork the Repository before making any commits.
   1. Please make commits to the Development Branch.
   1. Once done, please put in a Pull Request and a moderator will check it out.
   1. Please describe in the commits and pull requests what it is you are changing/fixing.


#### Credits/Acknowledgements
* Gerrit Bergen:
  * Website: https://www.gerritbergen.com/
  * GitHub: https://github.com/GerritBergen
  * For helping solve some of the issues and providing at least 30% of the inspiration!
* David Carr
  * Website: https://www.daveismyname.blog/
  * GitHub: https://github.com/daveismyname
  * He has some very helpful tutorials on his website as well as some amazing code examples!
* TinyMCE
  * Website: https://www.tiny.cloud/
  * They provide the edit fields used within the Admin Panel.
* Disqus
  * Website: https://disqus.com/
  * They provide the Comments/Discussion capabilities needed.