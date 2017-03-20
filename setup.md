# Set Up For Serving Wordpress Projects to a Digital Ocean Droplet with CodeShip and Ansible
#### By Emily Kaneff


##Table of Contents
* [Set up the VPS](#one)
* [Installing Ansible](#two)
* [Running the Ansible Playbook](#three)
* [Setting up CodeShip](#four)

<a name="one"></a>
## Step One: Set up the VPS

The first step in this whole process is going to be setting up the Virtual Private Server on Digital Ocean. This is done through their clickable interface on their website. 

1. Create a new Droplet on Digital Ocean
2. For this project we will need version 16.04 of Ubuntu, so select the Ubuntu 16.04 image
3. Choose the size acceptable for your application (in this case, use the $5/mo option)
4. Select a datacenter region that is located closest to you. The numbers represent the number of data centers in that region, and the highest number is just the newest one so it is safe to just select that one.
5. Additional options are recommended but not required. I suggest selecting Backups to allow yourself to roll back to older versions of your server in case any issues arise.
6. For this pipeline to work successfully, you will need to set up SSH key authentication for your VPS. If you do not know how to do this, you can follow this simple [tutorial](https://www.digitalocean.com/community/tutorials/how-to-use-ssh-keys-with-digitalocean-droplets). 
7. Choose a hostname that makes sense for your project and hit CREATE

>This process should be completed twice: once for a staging server and once for a production server.

<a name="two"></a>
## Step Two: Installing Ansible

The next step will be to install Ansible onto your machine. You can do that with the Homebrew command:

```shell
brew install ansible
```
>Note: If you do not have Homebrew installed, you can find how to do so [here](https://brew.sh/).

After that finishes, if you haven't already, download and place the files from this repository into the root of your project directory. 

<a name="three"></a>
## Step Three: Running the Ansible Playbook

Before running the playbook command, there are a few minor adjustments that need to be made to the playbook files. 

#### Maria

Under the Maria role, create a file in `vars` called `main.yml` and model the contents after the `.sample` version. This file will be git ignored, so it is important that you do not make your changes on the `.sample` file. Enter in the name of the database your wordpress site will be using. 

#### Staging, Production and Test

Within each of the Staging, Production and Test roles, a few changes need to be made to their variable files. For each role, change the IP to the IP of that particular server, and designate the project name (this will be the name of the configuration files) and the name of the group that will have ownership of this file. (Your non-root user will be added to this same group).

Also be sure to change the name of the `.j2` file located in templates to match the name of the project specified in the variables file for each of the server roles. 

#### Non-Root Users (waimag_user)

Included is a role that will create a user called `waimag_user` that is only able to make changes to the `waimag` project folder. 

Begin by changing the name of the folder itself to that of the user you are going to be creating if you plan to change it. 

Next, navigate to the `var` folder in that user folder, duplicate the `main.yml.sample` file, remove the `.sample` extension and fill in the information you need for your user. The `nonroot_password` should be encrypted following [these instructions.](http://docs.ansible.com/ansible/faq.html#how-do-i-generate-crypted-passwords-for-the-user-module) Use the output as the password for the `nonroot_password`. The group should be specific to the project, so having it match the name you gave the `project` variables in the other files would be wise (it should be the same name of the group you adjusted in the server files).  

Choose a name for your database, and user information for the database user that will have access to this database and this database only. 

> Note: In this configuration, we are using the default password for the root database user to complete the necessary commands to create users and add databases.  

In the `files` folder, duplicate the `authorized_keys.sample` file and remove the `.sample` extension. Paste in your new user's public ssh key. 

> Both the `main.yml` and `authorized_keys` files will be git ignored, so it is important that you do not make changes in the `.sample` version of these files, but rather make a duplicate and place your information there. 

#### Wordpress

In the wordpress role, the only change that needs to be made is the group name. This should match the name specified in every other location for the group, since it is here that the project directory will actually be added to the correct project group. 

> This script will also be pushing up it's own version of the `wp-config.php` that uses the variables specified for the database and the database user information, so there's no need to edit that file. 

Finally, on the root directory of the project is a `.gitignore` file. Within this, make sure to place a path to both the `main.yml` and the `authorized_keys` files respectively. 

> If you are running your wordpress project locally, make sure to add `wp-config.php` to the `.gitignore` to prevent sensitive information from being passed

With those files in place, we can now execute the playbook commands.

The first command you will need to run is: 

```shell
ansible all -m raw -s -a "sudo apt-get -y install python-simplejson" -u root --private-key=~/.ssh/[your ssh key name] -i ./hosts
```
>While setting up the ssh key, you should have at one point setup a name for that key that you could use to reference it. Make sure to place that name in the designated place within the above command.

This will install the needed python package onto the servers which will allow us to run our other ansible commands. 

Enter `yes` if prompted.

If your keys were successful, you should see two success messages about `python` being installed on both servers. 

This command only needs to be ran once per project. 

The last command you will need to run for this playbook is:

```shell
ansible-playbook --private-key=~/.ssh/[your ssh key name] -i ./hosts [name of your yml file].yml
```
This will begin executing the roles and installing the necessary dependancies to your servers. 

Once that completes, your server environments are ready to accept files. If you would like to check to see that everything ran smoothly, you can `ssh` into your server by running:

```shell
ssh [user]@[your ip]
```
> Since you created non root users, you should be able to ssh as either root or your non-root user if you created one for yourself with your public ssh key. 

Then navigate to the `/var/www/html` folder. Run an `ls` command and if you see the name of your project folder, everything went smoothly. 

<a name="four"></a>
## Step Four: Setting up CodeShip

Since we are implementing a centralized workflow using Git, we need a way to run tests and push our content to our servers after certain events take place on our Github repository. We can do this through a program called [CodeShip](http://codeship.com/). We can tell CodeShip to watch our repository on certain branches for activity and from there it will fire off any pre-setup scripts or tests that we specify, and on success we can have it actually deploy to our server. 

After signing up, you will be directed to the screen where you begin making a new project. Alternatively, if you are already signed in, you can select the button `Select Project...` in the top left of the screen to begin a new project.

You will then be redirected to a screen where there are three outlines steps, the first one being to connect an SCM. For this project, we will be using Github. 

Next, copy the clone URL from your project repository and paste it into the interface and click Connect. 

Since this tutorial is geared more towards smaller scale projects, selecting the Basic project type will be more than suitable for our needs. 

The next screen is where we can choose to implement any setup commands or test pipelines. Since we are not using one of the tech stacks outlined in their selections, writing your own custom scripts is fine. For this project, we don't need to run anything for setup and there is not a huge need for test commands right now, so we can just hit the `Save and go to dashboard` button at the bottom of the screen. 

Now CodeShip will tell you that you can trigger your first build by making a push to your repository. You can do this if you want to make sure that the connection is there, but we are going to skip to adding the deployment script. 

> Note that in your repository, you should have another branch set up with either the title of 'release' or 'staging' or something similar. That way we can tell CodeShip to watch for changes on that branch and deploy to the staging server, and then we can have it watch the 'master' branch to deploy to production. 

In the top right of the screen, select 'Project Settings' and then choose 'Deployment'. Type the name of the first branch you want to set a pipeline to. Save and continue. 

> I recommend setting up your staging branch first just in case anything breaks, that way you aren't making any major mistakes on the production server. 

You will then be prompted to select which app you want to use for deployment. Since we are using DigitalOcean and it is not a selectable option, scroll down and select 'Custom Script'. 

Now we have a couple of options that we could use here for deploying out files. CodeShip outlines them all nicely in this [article](https://documentation.codeship.com/basic/continuous-deployment/deployment-with-ftp-sftp-scp/#authenticating-via-ssh-public-keys). In this project, we are going to be using the `rsync` method. This is due to rsync's ability to only transfer the files that were changed or modified rather than everything to speed up the process. 

In the provided space, place this line: 

```shell
rsync -avz ~/clone/ ssh_user@your.server.com:/path/on/server/
```
> For this project, it is important that you have CodeShip run as the root user and place the ssh key for the project into the root `.ssh` folder.

Adjust the specifications as needed. The path on the server should match the path set up in the server config file in out ansible script. In this case, it would be `/var/www/html/wordpress`, since this is where we are telling nginx to look. 

Select 'Create Deployment' after that line is complete. If you would like to go ahead and set up the second deployment pipeline now, you can do so by selecting the 'Add new deployment pipeline' tab and repeating the same steps as previously outlined, but changing the IP used in the `rsync` line to that of the other server.  

Once that is finished, you are ready to begin pushing files to your repository. That process will be outlined in the [README.md](README.md) of this repository. 
