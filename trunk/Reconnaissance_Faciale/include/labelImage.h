#ifndef LABELIMAGE_H
#define LABELIMAGE_H

#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

////////////////////////////////////////////

class LabelImage
{
 private:
  int ID;
  cv::Mat image;

 public:
 inline LabelImage(int otherID, cv::Mat otherImage)
    {
      ID = otherID;
      image = otherImage;
    }

  inline int GetID()
  {
    return ID;
  }

  inline cv::Mat GetImage()
  {
    return image;
  }
};

#endif
