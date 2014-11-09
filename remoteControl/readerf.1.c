#include<stdio.h>
#include<unistd.h>
#include<fcntl.h>
#include<sys/types.h>
#include<sys/stat.h>
#include<string.h>
int main()
{
  FILE *file;
  file = fopen("array", "rb");
  unsigned char buff[168];
  fread(&buff, 1,168,file);



   int i;
   for(i = 0; i < 168; i++)
   {
     if(i > 155 && i < 160) printf("%c", buff[i]);
   }

}
