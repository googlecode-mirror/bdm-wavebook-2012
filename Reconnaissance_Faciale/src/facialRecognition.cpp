#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#include <iostream>
#include <iomanip>
#include <locale>
#include <sstream>
#include <string> 

#include <fstream>
#include <iostream>
#include <string>

#include <dirent.h>
#include <unistd.h>
#include <sys/stat.h>
#include <sys/types.h>

#include "facialRecognition.h"
#include "faceDetecter.h"
#include "labelImage.h"


using namespace cv;



std::vector<Mat> images;
std::vector<int> labels;

void initImages()
{
  string filepath,filepathSub, baseName="../Base_de_donnees/upload/", dirSub="/profile/reco/";
  DIR *dp,*dpSub;
  struct dirent *dirp,*dirpSub;
  struct stat filestat,filestatSub;
  Mat img;
  int label;

  dp = opendir( baseName.c_str() );
  if (dp == NULL)
    {
      std::cout << "Error opening " << baseName << std::endl;
      exit(1);
    }

  while ((dirp = readdir( dp )))
    {
      // we are reading dirs Base_de_donnees/upload/
      filepath = baseName  + dirp->d_name;

      stat( filepath.c_str(), &filestat );
      if (S_ISDIR( filestat.st_mode ) && (isdigit(dirp->d_name[0])))
	{
	  std::cout<<"Reading dir "<<filepath<<std::endl;
	  // we are reading dirs Base_de_donnees/upload/[ID]
	  // if we have a dir that starts with a digit, we take label	
	  label=atoi(dirp->d_name);
	  dpSub = opendir( (filepath+dirSub).c_str() );
	  if (dpSub == NULL)
	    {
	      std::cout << "Error opening (2) " << filepath+dirSub << std::endl;
	      exit(1);
	    }
	  while ((dirpSub = readdir( dpSub )))
	    {
	      // we are reading dirs Base_de_donnees/upload/[ID]/profile/
	      filepathSub = filepath + dirSub  + dirpSub->d_name;

	      // If the file is a directory (or is in some way invalid) we'll skip it
	      if (stat( filepathSub.c_str(), &filestatSub )) continue;
	      if (S_ISDIR( filestatSub.st_mode ))         continue;
	      std::cout<<"\tReading file "<<filepathSub<<" id = "<<label<<std::endl;

	      // we assume the file is an image: push back in the vector, and push back a label
	      images.push_back(imread(filepathSub, CV_LOAD_IMAGE_GRAYSCALE));
	      labels.push_back(label);
	    }
	  closedir( dpSub );
	}
    }
  closedir( dp );
}




int whois (Mat personToPredict)
{

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// Create a new Fisherfaces model 
  ///////////////////////////////////////////////////
  Ptr<FaceRecognizer> model =  createEigenFaceRecognizer();
  


  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// fill our vectors with database images/labels
  ///////////////////////////////////////////////////
  initImages();


  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// train our FaceRecognizer
  ///////////////////////////////////////////////////
  model->train(images, labels);
  printf("training done\n");
  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// test if the following pic belongs
  /////////////////////////////////////////////////// 
  return model->predict(personToPredict);
}


int main (int argc,char** argv)
{
  if(argc<2)
    {
      printf("Please specify an arguments:\n1 {pathToAnImage} for face recognition\n2 {pathToAnImage} reframe image\n");
      exit(-1);
    }
  switch(atoi(argv[1]))
    {
    case (1):
      {
	Mat imgPerson = imread(argv[2], CV_LOAD_IMAGE_GRAYSCALE);	
	int ret= whois(imgPerson);
	printf("Recognition done, the ugly guy on the picture has id %d\n",ret);
	return ret;
      }
      break;
    case (2):
      {
	std::string fileOut(argv[2]);
	size_t found=fileOut.find_last_of("/");
	// case we have a path
	if (found!=string::npos)
	  fileOut=fileOut.substr(found+1,fileOut.length()-1);
	// if there's no path, it's just a filename
	FaceDetecter detecter;
	Mat imgPerson = imread(argv[2], CV_LOAD_IMAGE_COLOR);	
	Mat imgPersonReframed;
	int retDetect=detecter.detectAndReframe(imgPerson,imgPersonReframed);
	if (retDetect==NO_FACE_FOUND)
	  return 0;
	if (argc>3)
	  {
	    // case the image is given for database purpose
	    // extra parameter is id
	    fileOut=string("../Base_de_donnees/upload/")+string(argv[3])+string("/profile/reco/R")+fileOut;
	  }
	else
	  {
	    // case the image is just for single face recognition
	    fileOut=string("../Base_de_donnees/tmp/R")+fileOut;
	  }
	if (imwrite(fileOut.c_str(),imgPersonReframed))
	  printf("image written to %s\n",fileOut.c_str());
	else
	  printf("failed to write image, check name validity: %s\n",fileOut.c_str());
	return retDetect;
      }
      break;
    }
  
  return 0;
}
