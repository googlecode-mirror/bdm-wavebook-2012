#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#include "faceDetecter.h"

using namespace cv;

int FaceDetecter::detectAndReframe( Mat frame,Mat& imOut)
{
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


  ///////////////////// TODO
  /// this extracts the rectangle from the image,
  /// as not all the face is on the resulting image 
  /// we should grow the rectangle maxFace (keeping its center to the same point)
  Mat faceROI = frame_gray( maxFace );
  imOut=faceROI;
  return ret;
}

