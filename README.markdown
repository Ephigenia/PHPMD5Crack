PHPMD5Crack
==============================================================================

This is the readme file of the PHPMD5Crack scrip collection that can help you recover your MD5 strings back to their original strings.


Rainbow Web Crack (`md5_rainbow_web_crack.php`)
==============================================================================

The Web Cracker tries to get the original string from an md5 string using a web service. That means that you have to be online and all php has to have access to the website that‘s used.

## Simple calls:

* `php md5_rainbow_web_crack.php [md5]`

this will try to get the original string of the md5 value using the online service and tell you if it's found or not.

## Using Files:

The script is designed to work with the piping and forwarding features that a modern shell gives you. So if you have some more hashes to check try one of these calls:

* `php md5_rainbow_web_crack.php < file_with_hashes.txt`
* `php md5_rainbow_web_crack.php dbexport.csv`

This will check every md5 hash found in the file (one per line, or if csv, md5 hash should be the last column!) and echo the results to you.

## output routing

You can direct the output of the file using shell output direction. Check these calls:

* `php md5_rainbow_web_crack.php < file_with_hashes.txt > results.txt`
* `php md5_rainbow_web_crack.php dbexport.csv > results.txt`

They will both echo their outputs to the `results.txt` file.


Dictionary Crack (`md5_dict_crack.php`)
==============================================================================

You can also try to crack single MD5 hashes including a salt string using a dictionary.

without salt:
* `php md5_dict_crack.php b5c0b187fe309af0f4d35982fd961d7e english.dict.txt`

with salt:
* `php md5_dict_crack.php e762b882d0c5f585a546588056af49f7 english.dict.txt test`

Check the results!
