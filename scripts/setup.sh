#/bin/bash
chown root *.sh
chmod u=rwx,go=xr *.sh

DIRNAME=$(dirname $(readlink -f $0))

COUNT=0
SCRIPTS=""
ASSOC=""

for file in root*.sh
do
    if [ $COUNT -gt 0 ] 
    then
       SCRIPTS=$SCRIPTS", "
    fi
    SCRIPTS=$SCRIPTS" \"/bin/bash "$DIRNAME/$file"\""
    ASSOC=$ASSOC$COUNT" => "$file"\n"
    COUNT=$(($COUNT + 1))
done

echo $ASSOC > $DIRNAME/associations.txt

/bin/cat << EOM > wrapper.c
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>

int
main (int argc, char *argv[])
{
    setuid (0);

    /* WARNING: Only use an absolute path to the script to execute,
     *          a malicious user might fool the binary and execute
     *          arbitary commands if not.
     * */
    if(argc == 1)
    {
        return 1;
    }

    static char * scripts[$COUNT] = { $SCRIPTS };

    system (scripts[atoi(argv[1])]);

    return 0;
}
EOM

gcc -c wrapper.c

gcc -o php_root wrapper.o

rm wrapper.c
rm wrapper.o
chown root php_root
chmod u=rwx,go=xr,+s php_root
