# Exonym Framework
> Based on [Presspack](https://github.com/jaredpalmer/presspack) by Jared Palmer [@jaredpalmer](https://twitter.com/jaredpalmer)

## First Time Setup
1. **Terminal:** Navigate to your working folder
2. `git clone REPOSITORY_HERE`


**(START: only if cloning the primary framework and starting a new project)**
---
1. Rename project folder
2. **Terminal** Navigate to renamed project folder
3. `rm -rf .git`
  - This removes the git instance so you don't overwrite the main Framework
  - Create new repository for the project on github
  - Follow instructions to create new git instance and make repository
---
**(END: only if cloning the primary framework and starting a new project)**


3. **Terminal:** Navigate to root of project folder
4. `yarn install`
5. Copy .env file into project folder root (ACF Pro install)
6. `composer install`
7. `docker-compose up`
8. `yarn start`

If all was successful, you will have a new browser window with an blank instance of the Exonym Framework.

## Get to Work!
1. **Terminal:** Navigate to root of project folder
2. `docker-compose up`
3. Open a second terminal window
4. `yarn start`
5. Open a third terminal window
  - This is your composer/git window to run short-term processes.
  - The docker and yarn terminal windows stay open while you're working on the project.

Edit files and watch them update with Browsersync! It's like magic.

### Stop Working Already!
1. **Terminal:** focus your git/composer window
2. `git add --all`
3. `git commit -m "your message for what work you did"`
4. `git push`
5. **Terminal:** focus your yarn window
6. `ctrl + c` to stop the yarn/browsersync process
7. **Terminal:** focus your docker window
8. `ctrl + c` to stop the docker process
9. `docker-compose down`

## Local Database Backup
Here's how to dump your local database with Docker into a `.sql` file

```aidl
docker exec -it exonym_docker /usr/bin/mysqldump -u wordpress exonym-docker_wordpress_1 > backup.sql
```

## Local Database Restore
Restore a previous database backup

```aidl
docker exec -i host_db_1 /usr/bin/mysql -u username -ppassword database_name < backup.sql
```
