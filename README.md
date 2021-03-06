# Deployment of Static Projects to a Digital Ocean Droplet with CodeShip
#### By Emily Kaneff

In the [setup](setup.md) tutorial, I had you run ansible scripts that created the necessary environment on your server in addition to prepping CodeShip to deploy the project files after changes have been made on the Github repository. 

In this walk through, I will be going through the process of pushing and doing pull requests on your repository to trigger the CodeShip scripts that will deploy your files. 

##Table of Contents
* [Using Gulp for Git](#one)
* [Creating a Pull Request](#two)
* [Handling the Pull Request](#three)
* [Watch CodeShip](#four)


<a name="one"></a>
## Step One: Using Gulp for Git

To make your workflow just a little bit easier, included in the repository is a `gulpfile` that can be used to make some initial git setup and git commands go by a little quicker. 

Since Gulp is a Node package, we need to install it using `npm` into our project. The `package.json` with the needed dependancies is already in the repo, to install Gulp and the other necessary packages, you can simply run: 

```shell
npm install
```

Once that finishes, if you are still located on your master branch, you can run the command `gulp` in your terminal and the Gulp tasks will create a release and development branch for you, preparing you for your feature branch workflow. 

Then, throughout your development process, instead of running the commands `git add` and `git commit`, you can simply run: 

```shell
gulp add --m [your commit message]
```
> After you run this command, run `git status` to double check that things were committed correctly. If it errors out and you still see the files as staged, try running the `gulp add` command again. 

When you are ready to push to your remote branches, you can both push and add a new tag in one command by running: 

```shell
gulp push --b [branch you want to push] --v [version for tag] --m [tag message]
```

This is meant to help take away some of the more repetitive tasks needed when doing a proper git workflow, and leaves less room for human error. 


<a name="two"></a>
## Step Two: Creating a Pull Request

Utilizing a centralized workflow means that all merges will be handled on a central point in the pipeline, such as Github. This means that instead of pushing directly to the master or release branches, the developers will be pushing their feature branches and then creating pull requests that will then be merged into the respective branches by an administrator for the repository.

Using feature branch workflow, you should have in the local version of the repository at least a master, release and development branch. It is from the development branch that you would make the individual feature branches. When your development branch is ready to be merged into release, simply run the command: 

```shell
git push origin [branch you want to push]

or 

gulp push --b [branch you want to push] --v [version for tag] --m [tag message]
```
This will create a new branch on Github and push your code into it.

<a name="three"></a>
## Step Three: Handling the Pull Request

Now you need to go to Github and you should see a little yellow bar with the title of your new branch in it. Select the 'Compare and pull request' button on the right. 

From this interface, can specify which branch you would like to act as your base and which new branch you would like to merge in, or 'compare' as they word it. 

Make sure that the title and comment sections are filled out with any relevant information the admin may need when looking at your pull request. When you are satisfied with your request, select the 'Create pull request' button. 

In this case, we are the administrators of this repository, so we are able to merge in the pull request immediately. If there are no conflicts to resolve, select the 'Merge pull request' button and confirm the merge. You can then delete the development branch as it will indicate that it is safe to do so. 

<a name="four"></a>
## Step Four: Watch CodeShip

Because of the `rsync` command we set up on CodeShip, merging into the correct branches is the only thing we have to do in order to deploy our files. However, if you navigate to the dashboard of your project, you will be ale to watch the progress of the deployment scripts as they fire.

If anything goes wrong, CodeShip will notify you of what happened and when in the pipeline and abort the process. You then have the option to rerun the build after attempting to resolve the issue.

> Don't forget that in order for CodeShip to work properly, you must append it's public ssh key into the `authorized_keys` file in your server. It will throw a `permission denied` error otherwise. 

What CodeShip does is it will clone down a copy of the repository into a `clone` folder, and then from there it will copy that code base to the specified location in the deployment script, that being `rsync` in our case. 

If CodeShip doesn't error out, then the file transfer happened successfully! You can now open your project in the browser at the IP of the server or the specified domain name laid out in the server configuration files in both the staging and production roles.

## Step Five: Choose Wordpress Theme

When you pull up the IP, you should be greeted by the Wordpress installation screen. Fill in the necessary information to get to the configuration interface. 

Once there, under `Appearance`, select the `Themes` option.

If you are using this code base, then located in the `wp-content/themes` folder is a theme titled `_s`. This is the theme used to this project, so to activate that as the main theme, simply click the `Activate` button on the theme. 

From then on, this will be the default theme used by the wordpress IP. 