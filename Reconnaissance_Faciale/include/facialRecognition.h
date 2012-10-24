#ifndef FACIALRECOGNITION_H
#define FACIALRECOGNITION_H

#include <iostream>
#include <string>

#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#define NO_FACE_FOUND -1
#define SINGLE_FACE_FOUND 1
#define MANY_FACES_FOUND 2

class LabelImage
{
 private:
  int ID;
  cv::Mat image;

 public:
  LabelImage(int otherID, cv::Mat otherImage)
    {
      ID = otherID;
      image = otherImage;
    }

  int GetID()
  {
    return ID;
  }

  cv::Mat GetImage()
  {
    return image;
  }
};


class FaceDetecter 
{
 private:
  cv::CascadeClassifier face_cascade;
  cv::CascadeClassifier eyes_cascade;

 public:
  inline FaceDetecter () 
  {
    /* paths to description of what we're looking for */
    std::string face_cascade_name = "OpenCV-2.4.2/data/haarcascades/haarcascade_frontalface_alt.xml";
    std::string eyes_cascade_name = "OpenCV-2.4.2/data/haarcascades/haarcascade_eye_tree_eyeglasses.xml";
    //-- 1. Load the cascades
    if( !face_cascade.load( face_cascade_name ) ){ printf("FaceDetecter:--(!)Error loading %s\n",face_cascade_name.c_str()); exit(-1); };
    if( !eyes_cascade.load( eyes_cascade_name ) ){ printf("FaceDetecter:--(!)Error loading %s\n",eyes_cascade_name.c_str()); exit(-1); };
    cv::RNG rng(12345);
  }

  int detectAndReframe(cv::Mat img,std::string pathWrite);
};
#endif
