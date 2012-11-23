#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#include "faceDetecter.h"

#define CONST_WIDTH 600
#define CONST_HEIGHT 750

using namespace cv;

int FaceDetecter::detectAndReframe( Mat frame,Mat& imOut)
{
  //****************************************************
  //****************************************************
  // TODO: this function should reframe well and set size to a constant
  //****************************************************
  //****************************************************


  std::vector<Rect> faces;
  Mat frame_gray;
  int ret=SINGLE_FACE_FOUND;

  cvtColor(frame, frame_gray, CV_BGR2GRAY);
  equalizeHist( frame_gray, frame_gray );

  //-- Detect faces
  face_cascade.detectMultiScale( frame_gray, faces, 1.1, 2, 0|CV_HAAR_SCALE_IMAGE, Size(30, 30) );

  if (faces.size()<=0)
    {
      return NO_FACE_FOUND;
    }

  // We now pick the biggest we've found
  Rect maxFace=faces[0];
  for( unsigned int i = 1; i < faces.size(); i++ )
    {
      // more than one face have been found 
      ret=MANY_FACES_FOUND;
      // comparaison with heights of faces
      if (faces[i].height>maxFace.height)
	{
	  maxFace=faces[i];
	}
    }

  /////////////////////// this codes create an ellipse around the face on the frame image
  /////////////////////// useful for debuging
  // pick the center of the face
  // Point center( maxFace.x + maxFace.width*0.5, maxFace.y + maxFace.height*0.5 );
  // ellipse( frame, center, Size( maxFace.width*0.5, maxFace.height*0.5), 0, 0, 360, Scalar( 255, 0, 255 ), 4, 8, 0 );
  ///////////////////////

  //***************************************************************************
  //***************************************************************************
  // cropping image, we need constant constant ratio width/height
  //***************************************************************************
  //***************************************************************************

  // say the factor is 15 of the width
  int coefW=50;
  int coefH=3;
  int factorWidth=(int)maxFace.width/coefW;
  int factorHeight=(int)maxFace.height/coefH;  
  Point decayFaceFactor(-factorWidth/2,-factorHeight/2);
  Size growFaceFactor(factorWidth,factorHeight);
  maxFace = maxFace + growFaceFactor;
  maxFace = maxFace + decayFaceFactor;
  
  
  //now we set aspect ratio to final one
  int ratio = CONST_HEIGHT / CONST_WIDTH;
  int myRatio = maxFace.height / maxFace.width;
  Point keepAOffset;
  Size keepADecay;
  if (!myRatio<ratio)
  {
	  //increase y

	keepAOffset=Point(-(ratio*maxFace.height-maxFace.width)/2,0);
	keepADecay=Size((ratio*maxFace.height-maxFace.width),0);
  }
  else
  {
	  //increase x
	keepAOffset=Point(0,-(ratio*maxFace.width-maxFace.height)/2);
	keepADecay=Size(0,(ratio*maxFace.width-maxFace.height));
  }

  maxFace = maxFace + keepAOffset;
  maxFace = maxFace + keepADecay;
  std::cout<<maxFace.width<<" "<<maxFace.height<<std::endl;
 
  Mat faceROI = frame_gray( maxFace );

  //***************************************************************************
  //***************************************************************************
  // resizing to const size
  //***************************************************************************
  //***************************************************************************

  resize(faceROI,imOut,Size(CONST_WIDTH,CONST_HEIGHT));
  

  return ret;
}

