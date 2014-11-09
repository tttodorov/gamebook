#include<stdio.h>
#include<unistd.h>
#include<fcntl.h>
#include<sys/types.h>
#include<sys/stat.h>
#include<string.h>
int main()
{
  FILE *file;
  file = fopen("button", "rb");
  unsigned char buff[4];
  fread(&buff, 1,4,file);


   if(buff[0] == 0xff && buff[1] == 0x7f && buff[2] == 0x02 && buff[3] == 0x04)
   {
     //printf("arrowRight\n");
     printf("1");
   }
   if(buff[0] == 0x01 && buff[1] == 0x80 && buff[2] == 0x02 && buff[3] == 0x04)
   {
    // printf("arrowLeft\n");
    printf("2");
   }
   if(buff[0] == 0x01 && buff[1] == 0x80 && buff[2] == 0x02 && buff[3] == 0x05)
   {
     //printf("arrowUp\n");
     printf("3");
   }
   if(buff[0] == 0xff && buff[1] == 0x7f && buff[2] == 0x02 && buff[3] == 0x05)
   {
    // printf("arrowDown\n");
     printf("4");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x00)
   {
    //printf("button1\n");
    printf("5");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x01)
   {
    //printf("button2\n");
    printf("6");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x02)
   {
    //printf("button3\n");
    printf("7");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x03)
   {
    //printf("button4\n");
    printf("8");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x05)
   {
    //printf("R1\n");
    printf("9");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x07)
   {
    // printf("R2\n");
    printf("10");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x04)
   {
     //printf("L1\n");
     printf("11");
   }
   if(buff[0] == 0x01 && buff[1] == 0x00 && buff[2] == 0x01 && buff[3] == 0x06)
   {
     //printf("L2\n");
     printf("12");
   }



//   printf("%x%x %x%x %x%x %x%x", buff[8], buff[9], buff[10], buff[11], buff[12], buff[13], buff[14], buff[15]);
  // printf("%x|%x|%x|%x", buff[157], buff[158], buff[159], buff[160]);
//  printf("%c", buff[160]);

 //  int i;
 //  for(i = 0; i < 4; i++)
 //  {
 //    switch(buff[0])
 //   {
 //    case 0xff : printf("arrowRight\n"); break;
 //   }
//   }

}
