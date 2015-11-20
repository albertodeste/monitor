#MONITOR

Simple PHP monitor application that returns status of specified commands.

SETUP

- Set the file settings.json according to your requirements (remember that validation is by ip-check so set your accepted ips)

- If you have .sh scripts to run create them inside the "scripts" directory.

- If you have .sh scripts as root create them inside the "scripts" directory named as root.script_name.sh and then run "sudo setup.sh" under the scripts directory. It will generate a file named php_root that will run your scripts as root. For example if you run "./php_root 0" it will run the relative script as root. the associations are described in the file named "associations.txt" generated by the "setup" script

SETTINGS.JSON FORMAT
- allowed_ips: array containing all the allowed ips to access this site
- timeout: number of milliseconds that page waits for auto-reload function (set to -1 for no auto-reload)
- sections: sections of the monitor, each one described as:
	- name: the name of the section, the corresponding value is an array with the voice of the section described as:
		- "name": the name of the voice
		- script: the shell command to execute
		- expected: the regex expression to validate the result, if not match the light will be red, otherwise it will be green.

NO LICENCE, you can use this code as you wish but without warranty.
