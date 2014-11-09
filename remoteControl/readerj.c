#include<stdio.h>
#include<unistd.h>
#include<fcntl.h>
#include<sys/types.h>
#include<sys/stat.h>
#include<string.h>
int main()
{
  FILE *file;
  file = fopen("/dev/input/js0", "rb");
  unsigned char buff[168];
  fread(&buff, 1,168,file);

// printf("%x ", buff[150]);


  // if(buff[12] == 0x0 && buff[13] == 0x0 && buff[14] == 0x2 && buff[15] == 0x5)
  //  printf("arrowDown\n");

//   printf("%x%x %x%x %x%x %x%x", buff[8], buff[9], buff[10], buff[11], buff[12], buff[13], buff[14], buff[15]);
  // printf("%x|%x|%x|%x", buff[157], buff[158], buff[159], buff[160]);
//  printf("%c", buff[160]);

   int i;
   for(i = 0; i < 168; i++)
   {
     printf("%c", buff[i]);
   }

}
