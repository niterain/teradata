PHP Task
========

Introduction
------------
This script is suppose to satisfy all the requirements below:

1. The script is a command-line script that runs 1 time. It reads the URL from a local config file and writes the size of the file (PDF, image, HTML, etc.) to an output file.
2. The script takes an input file that is a json array of URLs and the output file provides a json array that contains each URL, its size, and the total number of requests.
3. The script can now parse any HTML in the URL and report on the total size (i.e., the script figures out the size of all of the JavaScript, images, etc. and adds that to the total). It should also report on the total number of requests that were required for this.
