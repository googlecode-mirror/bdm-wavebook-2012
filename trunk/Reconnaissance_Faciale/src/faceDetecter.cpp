#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#include "faceDetecter.h"
#include <iostream>

using namespace cv;


bool FaceDetecter::isOutOfFrame(Mat imgIn,Rect roi) const
{
  // check for lower bounds
  if ((roi.x<0) || (roi.y<0) ||
      (roi.x+roi.width>imgIn.cols) || (roi.y+roi.height>imgIn.rows))
    return true;
  else 
    return false;
}

// we grow the ROI such that we reach the constant ratio
Rect FaceDetecter::growROIToRatioOnX (Rect roi) const
{
  Rect grownROI=roi;
  float xfactor=(float)roi.height*(float)this->ratio-(float)roi.width;
  int xfactori=(int)xfactor;
  Point factorDecay(xfactori/2,0);
  Size factorGrow(xfactori,0);

  grownROI=grownROI-factorDecay;
  grownROI=grownROI+factorGrow;

  return grownROI;
}

// we grow the ROI such that we reach the constant ratio
Rect FaceDetecter::growROIToRatioOnY (Rect roi) const
{
  Rect grownROI=roi;
  float yfactor=(float)roi.width/(float)this->ratio-(float)roi.height;
  int yfactori=(int)yfactor;
  Point factorDecay(0,yfactori/2);
  Size factorGrow(0,yfactori);
  grownROI=grownROI+factorGrow;
  grownROI=grownROI-factorDecay;

  return grownROI;
}

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
      printf("no face found on the image\n");
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

  switch(ret)
    {
    case MANY_FACES_FOUND:
      {
	printf("many faces have been found on the image given, we took the heighest\n");
      }
      break;
    case SINGLE_FACE_FOUND:
      {
	printf("just one face has been found on the image\n");
      }
      break;
    }

  // RATIO OF MAXFACE IS ALWAYS 1
  // therefore we add height, coz' targeted ratio is <1

  // the current ratio is superior to the one we want to reach:
  // current image is wider:
  // we grow the height
  Rect reframed=this->growROIToRatioOnY(maxFace);


  if (this->isOutOfFrame(frame_gray,reframed))
    {
      // we added on the y, but resulting image was out of frame
      // therefore we remove on x to keep aspect ratio without being out of frame
      reframed=this->growROIToRatioOnX(maxFace);
    }

  Mat faceROI = frame_gray( reframed );

  //***************************************************************************
  //***************************************************************************
  // resizing to const size
  //***************************************************************************
  //***************************************************************************

  // the final resize to reach constant width height dimensions
  resize(faceROI,imOut,Size(CONST_WIDTH,CONST_HEIGHT));
  

  return ret;
}

